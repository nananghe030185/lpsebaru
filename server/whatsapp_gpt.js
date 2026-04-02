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

let sock = []; // token -> Baileys socket
let qrcode = []; // token -> QR (data URL)
let pairingCode = []; // token -> pairing code (phone number linking)
let intervalStore = []; // token -> timers

const { setStatus } = require("./database/index");

// TODO: replace with your real path from the project
// The obfuscated file requires something that exports `IncomingMessage`
const { IncomingMessage } = require("./controllers/incomingMessage"); // <-- adjust

// TODO: replace with your real path from the project
// The obfuscated file requires something that exports these helpers
const {
  formatReceipt,
  getSavedPhoneNumber,
  prepareMediaMessage,
} = require("./lib/helper"); // <-- adjust

const MAIN_LOGGER = require("./lib/pino");
const NodeCache = require("node-cache");
const logger = MAIN_LOGGER.child({});
const msgRetryCounterCache = new NodeCache();

/**
 * Connect (or reuse connection) for a token.
 * If `usePairingCode` is true and creds have no `me`, will request a pairing code
 * via phone-number linking (instead of QR).
 */
const connectToWhatsApp = async (token, io = null, usePairingCode = false) => {
  // If we already have a QR prepared and we're not doing pairing-code flow, reuse it
  if (typeof qrcode[token] !== "undefined" && !usePairingCode) {
    io?.emit("qrcode", {
      token,
      data: qrcode[token],
      message: "please scan",
    });
    return {
      status: false,
      sock: sock[token],
      qrcode: qrcode[token],
      message: "please scan with your Whatsapp Accountt",
    };
  }

  // If we already have a pairing code and are in pairing-code flow, reuse it
  if (typeof pairingCode[token] !== "undefined" && usePairingCode) {
    io?.emit("pairing-code", {
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

  // If already connected, emit ready state
  try {
    // let jid = sock[token].user.id.split(":");
    let jid = sock[token].user.id.replace(":", "");
    // jid = jid[0] + "@g.us";
    jid = userId.split(":")[0] + "@s.whatsapp.net";
    const ppUrl = await getPpUrl(token, jid);
    io?.emit("open", { token, user: sock[token].user, ppUrl });
    delete qrcode[token];
    delete pairingCode[token];
    return { status: true, message: "Already connected" };
  } catch {
    io?.emit("message", { token, message: "Connecting.. (1).." });
  }

  // Start fresh connection
  const { version, isLatest } = await fetchLatestBaileysVersion();
  console.log(
    "You re using whatsapp gateway M Pedia v6.1.0 - Contact admin if any trouble : 6292298859671"
  );
  console.log(`using WA v${version.join(".")} , isLatest: ${isLatest}`);

  const { state, saveCreds } = await useMultiFileAuthState(
    `./credentials/${token}`
  );

  sock[token] = makeWASocket({
    version,
    // browser: Browsers.macOS("Chrome", "Mpedia"),
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

  // Pairing code flow: if asked, and creds don't have `me` yet
  if (usePairingCode && "me" in state.creds === false) {
    const phone = await getSavedPhoneNumber(token);
    try {
      const code = await sock[token].requestPairingCode(phone);
      pairingCode[token] = code;
    } catch {
      io?.emit("Unauthorized", { token, message: "Method Not Allowed" });
    }
    io?.emit("pairing-code", {
      token,
      data: pairingCode[token],
      message:
        "Go to whatsapp -> link device -> link with phone number, and pairing with this code.",
    });
  }

  // Event wiring
  // sock[token].ev.on(async (ev) => {
  //   // connection.update
  //   if (ev["connection.update"]) {
  //     const { connection, lastDisconnect, qr } = ev["connection.update"];
  sock[token].ev.on("connection.update", async (update) => {
    if (update.connection) {
      const { connection, lastDisconnect, qr } = update;
      if (connection === "close") {
        const statusCode = lastDisconnect?.error?.output?.payload?.statusCode;
        const errType = lastDisconnect?.error?.output?.payload?.error;

        // Only auto-reconnect on non-loggedOut reasons
        if (
          (lastDisconnect?.error instanceof Boom)?.output?.statusCode !==
          DisconnectReason.loggedOut
        ) {
          delete qrcode[token];
          io?.emit("message", { token, message: "Connection was lost" });

          if (statusCode == 401) {
            // Unauthorized — fully clean up
            sock[token].ws.close();
            delete qrcode[token];
            delete pairingCode[token];
            delete sock[token];
            io?.emit("message", {
              token,
              message: "Request QR ended. reload web to scan again",
            });
            return;
          }

          if (errType === "Unauthorized" || errType === "Method Not Allowed") {
            setStatus(token, "Disconnect");
            clearConnection(token);
            connectToWhatsApp(token, io);
          }

          if (statusCode === 408) connectToWhatsApp(token, io); // Timeout
          if (statusCode === 405) delete sock[token]; // Method Not Allowed
        } else {
          // loggedOut
          setStatus(token, "Disconnect");
          console.log("QR refs attempts ended");
          io?.emit("message", {
            token,
            message: "Connection closed. You are logged out.",
          });
          clearConnection(token);
          connectToWhatsApp(token, io);
        }
      }

      // Provide QR
      if (qr) {
        console.log("output", token);
        QRCode.toDataURL(qr, (err, url) => {
          if (err) console.error(err);
          qrcode[token] = url;
          connectToWhatsApp(token, io, usePairingCode);
        });
      }

      // connection-open
      if (connection === "open") {
        console.log("open");
        setStatus(token, "open");
        delete qrcode[token];
        delete pairingCode[token];

        let jid = sock[token].user.id.split(":");
        jid = jid[0] + "@g.us";
        const ppUrl = await getPpUrl(token, jid);

        io?.emit("open", { token, user: sock[token].user, ppUrl });
        delete qrcode[token];
        delete pairingCode[token];
      }
    }

    // creds.update (persist)
    if (update["creds.update"]) {
      await saveCreds(update["creds.update"]);
    }

    // messages.upsert (incoming messages -> your handler)
    if (update["messages.upsert"]) {
      const up = update["messages.upsert"];
      IncomingMessage(up, sock[token]);
    }
  });

  console.log("connectingxxxx...".qrcode[token]);
  return { sock: sock[token], qrcode: qrcode[token] };
};

/** Internal: ensure connection exists before send */
async function connectWaBeforeSend(token) {
  let isReady = undefined;
  const connected = await connectToWhatsApp(token);

  await connected.sock.ev.on("connection.update", (u) => {
    const { connection, qr } = u;
    if (connection === "open") isReady = true;
    if (qr) isReady = false;
  });

  // small wait loop for ready/qr state to resolve
  let tries = 0;
  while (typeof isReady === "undefined") {
    tries++;
    if (tries > 4) break;
    await new Promise((r) => setTimeout(r, 1000));
  }
  return isReady;
}

/** Send plain text */
const sendText = async (token, to, text) => {
  try {
    const res = await sock[token].sendMessage(formatReceipt(to), { text });
    return res;
  } catch {
    return false;
  }
};

/** Send raw message payload (already shaped) */
const sendMessage = async (token, to, payload) => {
  try {
    const res = await sock[token].sendMessage(
      formatReceipt(to),
      JSON.parse(payload)
    );
    return res;
  } catch {
    return false;
  }
};

/** Send media (image/video/document/audio[PTT]) */
async function sendMedia(
  token,
  to,
  mediatype,
  mediaUrlOrBuffer,
  caption,
  fileName,
  _mimetype
) {
  const jid = formatReceipt(to);
  let me = sock[token].user.id.replace(/:\d+/, "");

  if (mediatype === "audio") {
    return await sock[token].sendMessage(jid, {
      audio: { url: mediaUrlOrBuffer },
      ptt: true,
      mimetype: "audio/ogg",
    });
  }

  // Prepare media -> forward trick to preserve metadata
  const prepared = await prepareMediaMessage(sock[token], {
    caption: caption ? caption : "",
    fileName,
    media: mediaUrlOrBuffer,
    mediatype:
      mediatype !== "video" && mediatype !== "image" ? "document" : mediatype,
  });

  const message = { ...prepared.message };

  return await sock[token].sendMessage(jid, {
    forward: {
      key: { remoteJid: me, fromMe: true },
      message,
    },
  });
}

/** Send "buttons" style message (legacy interactive) */
async function sendButtonMessage(
  token,
  to,
  buttons,
  text,
  footer,
  imagePathOrUrl
) {
  let imageSource = "url"; // original code hinted it can be file too

  try {
    const btns = buttons.map((b, i) => ({
      buttonId: i,
      buttonText: { displayText: b.displayText },
      type: 1,
    }));

    let payload;
    if (imagePathOrUrl) {
      payload = {
        image:
          imageSource === "url"
            ? { url: imagePathOrUrl }
            : fs.readFileSync("./" + imagePathOrUrl),
        caption: text,
        footer,
        buttons: btns,
        headerType: 4,
        viewOnce: true,
      };
    } else {
      payload = {
        text,
        footer,
        buttons: btns,
        headerType: 1,
        viewOnce: true,
      };
    }

    const res = await sock[token].sendMessage(formatReceipt(to), payload);
    return res;
  } catch (e) {
    console.log(e);
    return false;
  }
}

/** Send template message (modern interactive) */
async function sendTemplateMessage(
  token,
  to,
  templateButtons,
  text,
  footer,
  imageUrl
) {
  try {
    let payload;
    if (imageUrl) {
      payload = {
        caption: text,
        footer,
        viewOnce: true,
        templateButtons,
        image: { url: imageUrl },
        viewOnce: true,
      };
    } else {
      payload = { text, footer, viewOnce: true, templateButtons };
    }

    const res = await sock[token].sendMessage(formatReceipt(to), payload);
    return res;
  } catch (e) {
    console.log(e);
    return false;
  }
}

/** Send list message */
async function sendListMessage(
  token,
  to,
  sections,
  titleText,
  footerText,
  title,
  buttonText
) {
  try {
    const payload = {
      text: titleText,
      footer: footerText,
      title,
      buttonText,
      sections: [sections],
    };
    const res = await sock[token].sendMessage(formatReceipt(to), payload, {
      ephemeralExpiration: 600000,
    });
    return res;
  } catch (e) {
    console.log(e);
    return false;
  }
}

/** Send a poll */
async function sendPollMessage(token, to, name, values, selectableCount) {
  try {
    const res = await sock[token].sendMessage(formatReceipt(to), {
      poll: { name, values, selectableCount },
    });
    return res;
  } catch (e) {
    console.log(e);
    return false;
  }
}

/** Fetch all groups user participates in */
async function fetchGroups(token) {
  try {
    let groups = await sock[token].groupFetchAllParticipating();
    let list = Object.entries(groups)
      .slice(0)
      .map((e) => e[1]);
    return list;
  } catch {
    return false;
  }
}

/** Check if a number / group exists */
async function isExist(token, target) {
  try {
    if (typeof sock[token] === "undefined") {
      const ok = await connectWaBeforeSend(token);
      if (!ok) return false;
    }
    if (target.includes("@g.us")) return true;
    else {
      const [result] = await sock[token].onWhatsApp("+" + target);
      return target.length > 11 ? result : true;
    }
  } catch {
    return false;
  }
}

/** Get profile picture URL (fallback to WhatsApp logo if none) */
async function getPpUrl(token, jid, _highRes) {
  let url;
  try {
    url = await sock[token].profilePictureUrl(jid);
    return url;
  } catch {
    return "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png";
  }
}

/** Delete credentials/session for a token and close connection */
async function deleteCredentials(token, io = null) {
  io !== null &&
    io.emit("message", { token, message: "Time out, please refresh page" });

  try {
    if (typeof sock[token] === "undefined") {
      const ok = await connectWaBeforeSend(token);
      if (ok) {
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

    if (io != null) {
      io.emit("Unauthorized", token);
      io.emit("message", {
        token,
        message: "Connection closed. You are logged out.",
      });
    }

    if (fs.existsSync(`./credentials/${token}`)) {
      fs.rm(
        `./credentials/${token}`,
        { recursive: true, force: true },
        (err) => {
          if (err) console.error(err);
        }
      );
    }

    return { status: true, message: "Deleting session and credential" };
  } catch (e) {
    console.error(e);
    return { status: true, message: "Nothing deleted" };
  }
}

/** Internal cleanup */
function clearConnection(token) {
  clearInterval(intervalStore[token]);
  delete sock[token];
  delete qrcode[token];
  setStatus(token, "Disconnect");

  if (fs.existsSync("./credentials/" + token)) {
    fs.rm("./credentials/" + token, { recursive: true, force: true }, (err) => {
      if (err) console.error(err);
    });
    console.log("credentials/" + token + " is deleted");
  }
}

/** HTTP initializer (checks token folder and tries to connect) */
async function initialize(req, res) {
  const { token } = req.body;

  if (token) {
    const f = require("fs");
    const credPath = "./credentials/" + token;

    if (f.existsSync(credPath)) {
      sock[token] = undefined;
      const ok = await connectWaBeforeSend(token);
      return ok
        ? res
            .status(200)
            .json({ status: true, message: token + " connection restored" })
        : res
            .status(200)
            .json({ status: false, message: token + " connection failed" });
    }

    return res.send({ status: false, message: token + " please scan" });
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
};
