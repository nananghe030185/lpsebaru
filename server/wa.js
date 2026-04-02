"use strict";

import {
    makeWASocket,
    DisconnectReason,
    useMultiFileAuthState,
    fetchLatestBaileysVersion,
    Browsers,
} from "@whiskeysockets/baileys";

import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";

import { Boom } from "@hapi/boom";
import qrcode from "qrcode";
import fs, { stat } from "fs";
import { setStatus, inboxMessage } from "./database/index.js";
let sock = [];

const app = express();
const server = createServer(app);
const io = new Server(server);

async function connectToWhatsApp(token, io, viaCode = false) {
    const { version, isLatest } = await fetchLatestBaileysVersion();
    console.log(`Using Baileys v${version.join(".")} , isLatest: ${isLatest}`);

    const { state, saveCreds } = await useMultiFileAuthState(
        `auth_info_baileys/${token}`
    );
    sock[token] = makeWASocket({
        // can provide additional config here
        auth: state,
        printQRInTerminal: false,
        browser: Browsers.ubuntu("Chrome"),
    });
    sock[token].ev.on("connection.update", (update) => {
        const { connection, lastDisconnect, qr } = update;
        console.log("=======================================", update, qr);
        if (qr && typeof qr !== "undefined") {
            console.log("QR RECEIVED", qr);
            // if (!viaCode) {
            //     io.emit("qr", { qr, device: token });
            //     io.emit("message", {
            //         message: "QR Code received, scan please!",
            //     });
            // }
            // generate qr code in base64
            qrcode.toDataURL(qr, (err, url) => {
                if (err) {
                    console.log("Error generating QR code", err);
                    return;
                }
                if (!viaCode) {
                    // if already connected, do not emit qr
                    if (typeof token !== "undefined") {
                        io.emit("qr", {
                            qr: url,
                            device: token,
                            message: "QR Code received, scan please!",
                        });
                    }
                }
                // console.log(url);
            });
        }
        if (connection === "close") {
            const statusCode =
                lastDisconnect?.error?.output?.payload?.statusCode;
            const errType = lastDisconnect?.error?.output?.payload?.error;
            const shouldReconnect =
                (lastDisconnect?.error instanceof Boom)?.output?.statusCode !==
                DisconnectReason.loggedOut;
            console.log(
                "connection closed due to ",
                lastDisconnect.error,
                ", reconnecting ",
                shouldReconnect
            );
            // reconnect if not logged out
            if (shouldReconnect) {
                console.log(
                    " ================= Reconnecting... ================" +
                        statusCode +
                        " " +
                        errType
                );
                if (
                    errType === "Stream Errored" ||
                    errType === "Connection Closed" ||
                    errType === "Timed Out" ||
                    statusCode == 428 ||
                    statusCode == 515
                ) {
                    setStatus(token, "reconnecting");
                    connectToWhatsApp(token, io);
                } else {
                    setStatus(token, "Disconnect");
                }
                // if (statusCode == 401) {
                //     // Unauthorized — fully clean up
                //     // sock[token].ws.close();
                //     // delete sock[token];
                //     // delete pairingCode[token];
                //     delete sock[token];
                //     io?.emit("message", {
                //         token,
                //         message: "Request QR ended. reload web to scan again",
                //     });
                //     return;
                // }
                // if (
                //     errType === "Unauthorized" ||
                //     errType === "Method Not Allowed"
                // ) {
                //     setStatus(token, "Disconnect");
                //     clearConnection(token);
                //     connectToWhatsApp(token, io);
                // }
                // if (statusCode === 408) connectToWhatsApp(token, io); // Timeout
                // if (statusCode === 405) delete sock[token]; // Method Not Allowed
            }
        } else if (connection === "open") {
            console.log("opened connection ===== ", sock[token]);

            // set status online in db
            const res = setStatus(token, "connected");

            // send device info
            let jid = sock[token].user.id.split(":");
            jid = jid[0] + "@s.whatsapp.net";

            const ppUrl = getPpUrl(token, jid, "image");
            ppUrl.then((r) => console.log("=======================> " + r));
            // ppUrl.then((r) =>
            //     console.log("promise ppurl ================" + r)
            // );
            // io.emit("open", { device: token, ppUrl: ppUrl });
        }
    });
    sock[token].ev.on("messages.upsert", (event) => {
        for (const m of event.messages) {
            console.log(JSON.stringify(m, undefined, 2));

            console.log("replying to=================", m.key.remoteJid);
            // await sock[token].sendMessage(m.key.remoteJid!, { text: 'Hello Word' })
            const jid = m.key.remoteJid.split("@")[0]; // "6287821996965@s.whatsapp.net
            // const message = m.message.extendedTextMessage.text; // "Halo"
            //chekc if message is not empty
            let message = "";
            if (m.message?.extendedTextMessage?.text) {
                message = m.message.extendedTextMessage.text;
                inboxMessage(jid, message);
            }

            // reply only if message is not from me
            // if (!m.key.fromMe) {
            //     sock[token]
            //         .sendMessage(jid, { text: "You said: " + message })
            //         .then((result) => console.log("Result: ", result))
            //         .catch((err) => {
            //             console.log("Error: ", err);
            //         });
            // }
        }
    });

    // to storage creds (session info) when it updates
    sock[token].ev.on("creds.update", saveCreds);

    return sock[token];
}

/** Internal cleanup */
async function clearConnection(token) {
    clearInterval(intervalStore[token]);
    delete sock[token];
    delete qrcode[token];
    setStatus(token, "Disconnect");

    if (fs.existsSync("./credentials/" + token)) {
        fs.rm(
            "./credentials/" + token,
            { recursive: true, force: true },
            (err) => {
                if (err) console.error(err);
            }
        );
        console.log("credentials/" + token + " is deleted");
    }
}

// delete credentials
async function deleteCredentials(device, io) {
    try {
        const dir = `./auth_info_baileys/${device}`;
        if (fs.existsSync(dir)) {
            fs.rmSync(dir, { recursive: true, force: true });
            console.log("Credentials deleted");
            io.emit("message", { message: "Device logged out" });
        } else {
            console.log("No credentials found");
            io.emit("message", { message: "No device to logout" });
        }

        if (sock[device]) {
            sock[device].logout();
            delete sock[device];
        }

        // set status offline in db
        const res = setStatus(device, "disconnected");
        console.log("setStatus", res);
    } catch (err) {
        console.error("Error deleting credentials", err);
    }
}

async function getPpUrl(token, jid, _highRes) {
    let url;
    try {
        console.log("getPpUrl jid: ", jid);
        if (!sock[token]) {
            return "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png";
        }
        // get profile picture url
        // url = await sock[token].profilePictureUrl(jid, _highRes);
        // return url;
        // get profile picture in base64
        const pp = await sock[token].profilePictureUrl(jid, "image");
        console.log("pp url==================>", pp);
        // const response = await fetch(pp);
        // const buffer = await response.arrayBuffer();
        // const base64 = Buffer.from(buffer).toString("base64");
        // return "data:image/jpeg;base64," + base64;

        return "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png";
    } catch {
        return "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png";
    }
}

async function sendMessage(token, number, message) {
    if (!sock[token]) {
        connectToWhatsApp(token);
        return {
            status: false,
            result: {
                message: "Device not connected",
            },
        };
    }
    const id = number.includes("@s.whatsapp.net")
        ? number
        : number + "@s.whatsapp.net";
    try {
        const result = await sock[token].sendMessage(id, { text: message });
        console.log("sendMessage result", result);
        return { status: true, result: result };
    } catch (err) {
        console.log("Error sending message: ", err);
        return { status: false, message: "Error sending message", error: err };
    }
}

// send buuton message
async function sendButtonMessage(token, number, message, buttons) {
    if (!sock[token]) {
        return { status: false, message: "Device not connected" };
    }
    const id = number.includes("@s.whatsapp.net")
        ? number
        : number + "@s.whatsapp.net";
    try {
        const result = await sock[token].sendMessage(id, {
            text: message,
            buttons: buttons,
            headerType: 1,
        });
        console.log("sendButtonMessage result", result);
        return { status: true, result: result };
    } catch (err) {
        console.log("Error sending button message: ", err);
        return {
            status: false,
            message: "Error sending button message",
            error: err,
        };
    }
}

// send image message
async function sendImageMessage(token, number, caption, imageUrl) {
    if (!sock[token]) {
        return { status: false, message: "Device not connected" };
    }
    const id = number.includes("@s.whatsapp.net")
        ? number
        : number + "@s.whatsapp.net";
    try {
        const result = await sock[token].sendMessage(id, {
            image: { url: imageUrl },
            caption: caption,
        });
        console.log("sendImageMessage result", result);
        return { status: true, result: result };
    } catch (err) {
        console.log("Error sending image message: ", err);
        return {
            status: false,
            message: "Error sending image message",
            error: err,
        };
    }
}

export default {
    connectToWhatsApp,
    deleteCredentials,
    getPpUrl,
    sendMessage,
    sendButtonMessage,
    sendImageMessage,
    clearConnection,
};
