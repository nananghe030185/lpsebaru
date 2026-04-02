const {
  default: makeWASocket,
  downloadContentFromMessage,
  prepareWAMessageMedia,
  generateWAMessageFromContent,
} = require("@whiskeysockets/baileys");
const mime = require("mime-types");
const fs = require("fs");
const { join } = require("path");
const { default: axios } = require("axios");

// Format WhatsApp JID/number
function formatReceipt(number) {
  try {
    if (number.endsWith("@g.us") || number.endsWith("@c.us")) return number;
    let num = number.replace(/\D/g, "");
    if (num.startsWith("0")) num = "62" + num.substr(1);
    if (!num.endsWith("@c.us")) num += "@c.us";
    return num;
  } catch (e) {
    return number;
  }
}

// Async forEach helper
async function asyncForEach(array, callback) {
  for (let i = 0; i < array.length; i++) {
    await callback(array[i], i, array);
  }
}

// Remove forbidden characters from string
async function removeForbiddenCharacters(str) {
  return str.replace(/[\x00-\x1F\x7F-\x9F'\\"]/g, "");
}

// Parse incoming WhatsApp message
async function parseIncomingMessage(msg) {
  const messageType = Object.keys(msg.message || {})[0];
  let text =
    messageType === "conversation" && msg.message.conversation
      ? msg.message.conversation
      : messageType === "imageMessage" && msg.message.imageMessage.caption
      ? msg.message.imageMessage.caption
      : messageType === "videoMessage" && msg.message.videoMessage.caption
      ? msg.message.videoMessage.caption
      : messageType === "extendedTextMessage" &&
        msg.message.extendedTextMessage.text
      ? msg.message.extendedTextMessage.text
      : messageType === "listResponseMessage" &&
        msg.message.listResponseMessage.title
      ? msg.message.listResponseMessage.title
      : messageType === "buttonsResponseMessage"
      ? msg.message.buttonsResponseMessage.selectedDisplayText
      : "";
  const command = await removeForbiddenCharacters(text.toLowerCase());
  const from = msg.key.remoteJid.split("@")[0];
  let bufferImage = undefined;
  if (messageType === "imageMessage") {
    const stream = await downloadContentFromMessage(
      msg.message.imageMessage,
      "image"
    );
    let buffer = Buffer.from([]);
    for await (const chunk of stream) {
      buffer = Buffer.concat([buffer, chunk]);
    }
    bufferImage = buffer.toString("base64");
  }
  return { command, bufferImage, from };
}

// Simulate getting saved phone number (delayed promise)
function getSavedPhoneNumber(token) {
  return new Promise((resolve, reject) => {
    if (token) setTimeout(() => resolve(token), 2000);
    else reject(new Error("Nomor telepon tidak ditemukan."));
  });
}

// Prepare media message for sending
const prepareMediaMessage = async (sock, opts) => {
  try {
    const mediaType = opts.mediatype;
    const mediaKey = mediaType + "Message";
    if (mediaType === "document" && !opts.fileName) {
      const match = /.*\/(.+?)\./.exec(opts.media);
      opts.fileName = match[1];
    }
    let mimetype = mime.lookup(opts.media);
    if (!mimetype) {
      const resp = await axios.head(opts.media);
      mimetype = resp.headers["content-type"];
    }
    if (opts.fileName && opts.fileName.endsWith(".cdr")) {
      mimetype = "application/cdr";
    }
    const prepared = await prepareWAMessageMedia(
      { [mediaType]: { url: opts.media } },
      { upload: sock.waUploadToServer }
    );
    prepared[mediaKey].caption = opts?.caption;
    prepared[mediaKey].mimetype = mimetype;
    prepared[mediaKey].fileName = opts.fileName;
    if (opts.mediatype === "video") {
      prepared[mediaKey].jpegThumbnail = Uint8Array.from(
        fs.readFileSync(
          join(process.cwd(), "public", "images", "video-cover.png")
        )
      );
      prepared[mediaKey].gifPlayback = false;
    }
    let userJid = sock.user.id.replace(/:\d+/, "");
    return await generateWAMessageFromContent(
      "",
      { [mediaKey]: { ...prepared[mediaKey] } },
      { userJid }
    );
  } catch (err) {
    console.log("error prepare", err);
    return false;
  }
};

module.exports = {
  formatReceipt,
  asyncForEach,
  removeForbiddenCharacters,
  parseIncomingMessage,
  getSavedPhoneNumber,
  prepareMediaMessage,
};
