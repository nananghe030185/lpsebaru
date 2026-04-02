"use strict";

const { Boom } = require("@hapi/boom");
const {
    default: makeWASocket,
    Browsers,
    fetchLatestBaileysVersion,
    useMultiFileAuthState,
    makeCacheableSignalKeyStore,
    DisconnectReason,
} = require("@whiskeysockets/baileys");
const QRCode = require("qrcode");
const fs = require("fs");
const { setStatus } = require("./database/index");
const { IncomingMessage } = require("./lib/pino");
const {
    formatReceipt,
    getSavedPhoneNumber,
    prepareMediaMessage,
} = require("./lib/helper");
const MAIN_LOGGER = require("./lib/pino");
const NodeCache = require("node-cache");
const logger = MAIN_LOGGER.child({});
const msgRetryCounterCache = new NodeCache();

let sock = [],
    qrcode = [],
    pairingCode = [],
    intervalStore = [];

// Connect to WhatsApp
const connectToWhatsApp = async (
    token,
    socketIo = null,
    usePairing = false
) => {
    console.log("ini tokennya ===========", token, qrcode, qrcode[token]);
    if (typeof qrcode[token] !== "undefined" && !usePairing) {
        socketIo?.emit("qrcode", {
            token,
            data: qrcode[token],
            message: "please scan",
        });
        return {
            status: false,
            sock: sock[token],
            qrcode: qrcode[token],
            message: "please scan",
        };
    }
    if (typeof pairingCode[token] !== "undefined" && usePairing) {
        // socketIo?.emit("pairing-code", {
        socketIo?.emit("code", {
            token,
            data: pairingCode[token],
            message:
                "Go to whatsapp -> link device -> link with phone number, and pairing with this code.",
        });
        return {
            status: false,
            code: pairingCode[token],
            message: "pairing with that code",
        };
    }
    try {
        // let jid = sock[token].user.id.split(':');
        let userId = sock[token].user.id.replace(":", "");
        // jid = jid[0] + '@g.us';
        userId = userId.split(":")[0] + "@s.whatsapp.net";
        const ppUrl = await getPpUrl(token, userId);
        // io?.emit('open', { token, user: sock[token].user, ppUrl });
        socketIo?.emit("user", { token, user: sock[token].user, ppUrl });
        delete qrcode[token];
        delete pairingCode[token];
        return { status: true, message: "Already connected" };
    } catch (e) {
        socketIo?.emit("message", {
            token,
            message: "please scan with your Whatsapp Accountt",
        });
    }

    // Start fresh connection
    const { version, isLatest } = await fetchLatestBaileysVersion();
    const { state, saveCreds } = await useMultiFileAuthState(
        `./credentials/${token}`
    );
    console.log(
        "################## Dibuat oleh ESOft Media",
        qrcode[token],
        token
    );
    sock[token] = makeWASocket({
        version,
        // browser: Browsers.macOS('Chrome', 'Mpedia'),
        browser: Browsers.macOS("Mpedia"),
        logger,
        printQRInTerminal: false,
        auth: {
            creds: state.creds,
            keys: makeCacheableSignalKeyStore(state.keys, logger),
        },
        msgRetryCounterCache,
        generateHighQualityLinkPreview: true,
    });

    if (usePairing && !("me" in state.creds) === false) {
        const phoneNumber = await getSavedPhoneNumber(token);
        try {
            const code = await sock[token].requestPairingCode(phoneNumber);
            pairingCode[token] = code;
        } catch (err) {
            // io?.emit('Unauthorized', { token, message: 'Method Not Allowed' });
            socketIo?.emit("code", {
                token,
                message:
                    "Go to whatsapp -> link device -> link with phone number, and pairing with this code.",
            });
        }
        //io?.emit('pairing-code', {
        socketIo?.emit("code", {
            token,
            data: pairingCode[token],
            message:
                "Go to whatsapp -> link device -> link with phone number, and pairing with this code.",
        });
    }

    //sock[token].ev.on(async (ev) => {
    // connection.update
    // if (ev['connection.update']) {
    sock[token].ev.on("connection.update", async (update) => {
        if (update.connection) {
            const { connection, lastDisconnect, qr } = update;
            if (connection === "close") {
                const statusCode =
                    lastDisconnect?.error?.output?.payload?.statusCode;
                const errorMsg = lastDisconnect?.error?.output?.payload?.error;
                if (
                    (lastDisconnect?.error instanceof Boom)?.output
                        ?.statusCode !== DisconnectReason.loggedOut
                ) {
                    delete qrcode[token];
                    socketIo?.emit("message", {
                        token,
                        message: "Connection was lost",
                    });
                    if (statusCode == 401) {
                        sock[token].ws.close();
                        delete qrcode[token];
                        delete pairingCode[token];
                        delete sock[token];
                        socketIo?.emit("message", {
                            token,
                            message: "Connection closed. You are logged out.",
                        });
                        return;
                    }
                    if (
                        errorMsg === "Unauthorized" ||
                        errorMsg === "Method Not Allowed"
                    ) {
                        setStatus(token, "Disconnect");
                        clearConnection(token);
                        connectToWhatsApp(token, socketIo);
                    }
                    if (statusCode === 408) connectToWhatsApp(token, socketIo); // Timeout
                    if (statusCode === 405) delete sock[token]; // Method Not Allowed
                } else {
                    setStatus(token, "Disconnect");
                    console.log("Connection closed. You are logged out.");
                    socketIo?.emit("message", {
                        token,
                        message: "Connection closed. You are logged out.",
                    });
                    clearConnection(token);
                    connectToWhatsApp(token, socketIo);
                }
            }
            // Provide QR
            if (qr) {
                console.log("please scan", token);
                QRCode.toDataURL(qr, function (err, url) {
                    if (err) console.log(err);
                    qrcode[token] = url;
                    connectToWhatsApp(token, socketIo, usePairing);
                });
            }
            // connection-open
            if (connection === "open") {
                console.log("Connecting.. (1)..");
                setStatus(token, "Connect");
                delete qrcode[token];
                delete pairingCode[token];
                // let jid = sock[token].user.id.split(':');
                let userId = sock[token].user.id.replace(":", "");
                //jid = jid[0] + '@g.us';
                userId = userId.split(":")[0] + "@s.whatsapp.net";
                const ppUrl = await getPpUrl(token, userId);
                socketIo?.emit("user", {
                    token,
                    user: sock[token].user,
                    ppUrl,
                });
                delete qrcode[token];
                delete pairingCode[token];
            }
        }
        if (update["creds.update"]) {
            const creds = update["creds.update"];
            saveCreds(creds);
        }
        if (update["messages.upsert"]) {
            const messages = update["messages.upsert"];
            IncomingMessage(messages, sock[token]);
        }
    });

    console.log(`Connecting.. (2)..${token}`);
    return { sock: sock[token], qrcode: qrcode[token] };
};

// Helper to connect before sending
async function connectWaBeforeSend(token) {
    let isConnected = undefined,
        result;
    result = await connectToWhatsApp(token);
    await result.sock.ev.on("connection.update", (update) => {
        const { connection, qr } = update;
        if (connection === "open") isConnected = true;
        if (qr) isConnected = false;
    });
    let tries = 0;
    while (typeof isConnected === "undefined") {
        tries++;
        if (tries > 4) break;
        await new Promise((res) => setTimeout(res, 1000));
    }
    return isConnected;
}

// Send text message
const sendText = async (token, jid, text) => {
    try {
        const result = await sock[token].sendMessage(formatReceipt(jid), {
            text,
        });
        return result;
    } catch (e) {
        return false;
    }
};

// Send any message
const sendMessage = async (token, jid, message) => {
    try {
        const result = await sock[token].sendMessage(
            formatReceipt(jid),
            JSON.parse(message)
        );
        return result;
    } catch (e) {
        return false;
    }
};

// Send media (image, video, audio, document)
async function sendMedia(token, jid, type, mediaUrl, caption, fileName, extra) {
    const receipt = formatReceipt(jid);
    let userId = sock[token].user.id.replace(/:\d+/, "");
    if (type == "audio") {
        return await sock[token].sendMessage(receipt, {
            audio: { url: mediaUrl },
            ptt: true,
            // mimetype: 'audio/ogg',
            mimetype: "audio/mp4",
        });
    }
    const prepared = await prepareMediaMessage(sock[token], {
        caption: caption ? caption : "",
        fileName: fileName,
        media: mediaUrl,
        mediatype: type !== "video" && type !== "image" ? "document" : type,
    });
    const message = { ...prepared.message };
    return await sock[token].sendMessage(receipt, {
        forward: {
            key: { remoteJid: userId, fromMe: true },
            message,
        },
    });
}

// Send button message
async function sendButtonMessage(token, jid, buttons, text, footer, image) {
    try {
        const btns = buttons.map((btn, i) => ({
            buttonId: i,
            buttonText: { displayText: btn.displayText },
            type: 1,
        }));
        let msg;
        if (image)
            msg = {
                image:
                    typeof image == "url"
                        ? { url: image }
                        : fs.readFileSync("./uploads/" + image),
                caption: text,
                footer,
                buttons: btns,
                headerType: 4,
                viewOnce: true,
            };
        else
            msg = {
                text,
                footer,
                buttons: btns,
                headerType: 1,
                viewOnce: true,
            };
        const result = await sock[token].sendMessage(formatReceipt(jid), msg);
        return result;
    } catch (e) {
        console.log(e);
        return false;
    }
}

// Send template message
async function sendTemplateMessage(
    token,
    jid,
    templateButtons,
    text,
    footer,
    image
) {
    try {
        let msg;
        if (image)
            msg = {
                caption: text,
                footer,
                viewOnce: true,
                templateButtons,
                image: { url: image },
            };
        else
            msg = {
                text,
                footer,
                viewOnce: true,
                templateButtons,
            };
        const result = await sock[token].sendMessage(formatReceipt(jid), msg);
        return result;
    } catch (e) {
        console.log(e);
        return false;
    }
}

// Send list message
async function sendListMessage(
    token,
    jid,
    sections,
    text,
    footer,
    title,
    buttonText
) {
    try {
        const msg = {
            text,
            footer,
            title,
            buttonText,
            sections: [sections],
        };
        const result = await sock[token].sendMessage(formatReceipt(jid), msg, {
            ephemeralExpiration: 600000,
        });
        return result;
    } catch (e) {
        console.log(e);
        return false;
    }
}

// Send poll message
async function sendPollMessage(token, jid, name, values, selectableCount) {
    try {
        const result = await sock[token].sendMessage(formatReceipt(jid), {
            poll: { name, values, selectableCount },
        });
        return result;
    } catch (e) {
        console.log(e);
        return false;
    }
}

// Fetch groups
async function fetchGroups(token) {
    try {
        let groups = await sock[token].groupFetchAllParticipating();
        let groupList = Object.entries(groups)
            // slice(0)
            .slice(0)[0]
            .map((g) => g[1]);
        return groupList;
    } catch (e) {
        return false;
    }
}

// Check if number exists
async function isExist(token, number) {
    try {
        if (typeof sock[token] === "undefined") {
            const connected = await connectWaBeforeSend(token);
            if (!connected) return false;
        }
        if (number.endsWith("@g.us")) return true;
        else {
            const [result] = await sock[token].onWhatsApp("+" + number);
            return number.length > 11 ? result : true;
        }
    } catch (e) {
        return false;
    }
}

// Get profile picture URL
async function getPpUrl(token, jid, fallback) {
    let url;
    try {
        url = await sock[token].profilePictureUrl(jid);
        return url;
    } catch (e) {
        return "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png";
    }
}

// Delete credentials/session
async function deleteCredentials(token, socketIo = null) {
    socketIo !== null &&
        socketIo.emit("message", {
            token,
            message: "Deleting session and credential",
        });
    try {
        if (typeof sock[token] === "undefined") {
            const connected = await connectWaBeforeSend(token);
            if (connected) {
                sock[token].logout();
                delete sock[token];
            }
        } else {
            sock[token].logout();
            delete sock[token];
        }
        delete qrcode[token];
        clearInterval(intervalStore[token]);
        setStatus(token, "Disconnect");
        if (socketIo != null) {
            socketIo.emit("Unauthorized", token);
            socketIo.emit("message", {
                token,
                message: "Connection closed. You are logged out.",
            });
        }
        if (fs.existsSync("./credentials/" + token)) {
            fs.rm(
                "./credentials/" + token,
                { recursive: true, force: true },
                (err) => {
                    if (err) console.log(err);
                }
            );
        }
        return { status: true, message: "Deleting session and credential" };
    } catch (e) {
        console.log(e);
        return { status: true, message: "Nothing deleted" };
    }
}

// Clear connection and remove credentials
function clearConnection(token) {
    clearInterval(intervalStore[token]);
    delete sock[token];
    delete qrcode[token];
    setStatus(token, "Disconnect");
    if (fs.existsSync("./credentials/" + token)) {
        fs.rm(
            "./credentials/" + token,
            { recursive: true, force: true },
            (err) => {
                if (err) console.log(err);
            }
        );
        console.log("./credentials/" + token + " is deleted");
    }
}

// Initialize WhatsApp session
async function initialize(req, res) {
    const { token } = req.body;
    if (token) {
        const fs = require("fs");
        const credPath = "./credentials/" + token;
        if (fs.existsSync(credPath)) {
            sock[token] = undefined;
            const connected = await connectWaBeforeSend(token);
            return connected
                ? res
                      .status(200)
                      .json({ status: true, message: token + " connected" })
                : res.status(200).json({
                      status: false,
                      message: token + " not connected",
                  });
        }
        return res.send({ status: false, message: token + " not found" });
    }
    return res.send({ status: false, message: "Wrong Parameterss" });
}

module.exports = {
    connectToWhatsApp,
    sendText,
    sendMedia,
    sendButtonMessage,
    sendTemplateMessage,
    sendListMessage,
    sendPollMessage,
    isExist,
    getPpUrl,
    fetchGroups,
    deleteCredentials,
    sendMessage,
    initialize,
    connectWaBeforeSend,
    sock,
    default: makeWASocket,
};
