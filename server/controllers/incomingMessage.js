const {
  parseIncomingMessage,
  formatReceipt,
  prepareMediaMessage,
} = require("../lib/helper");
require("dotenv").config();
const axios = require("axios");
const {
  isExistsEqualCommand,
  isExistsContainCommand,
  getUrlWebhook,
} = require("../database/model");

// Handle incoming WhatsApp message
const IncomingMessage = async (messages, sock) => {
  try {
    let isQuoted = false;
    if (!messages["messages"]) return;
    messages = messages["messages"][0];
    const pushName = messages?.pushName || "";
    if (messages.key.fromMe === true) return;
    if (messages.key.remoteJid === "status@broadcast") return;
    const participant =
      messages.key.participant && formatReceipt(messages.key.participant);
    const { command, bufferImage, from } = await parseIncomingMessage(messages);

    let replyData, replyRows;
    const device = sock.user.id.split(":")[0];
    // Check for Equal command
    const equalRows = await isExistsEqualCommand(command, device);
    if (equalRows.length > 0) {
      replyRows = equalRows;
    } else {
      // Check for Contain command
      replyRows = await isExistsContainCommand(command, device);
    }

    if (replyRows.length === 0) {
      // No autoreply found, try webhook
      const webhookUrl = await getUrlWebhook(device);
      if (webhookUrl == null) return;
      const webhookResult = await sendWebhook({
        command,
        bufferImage,
        from,
        url: webhookUrl,
        participant,
      });
      if (webhookResult === false) return;
      if (webhookResult === undefined) return;
      if (typeof webhookResult !== "object") return;
      isQuoted = webhookResult?.quoted ? true : false;
      replyData = JSON.stringify(webhookResult);
    } else {
      // Autoreply found
      let replyorno =
        replyRows[0].reply_when == "All"
          ? true
          : replyRows[0].reply_when == "Group" &&
            messages.key.remoteJid.includes("@g.us")
          ? true
          : replyRows[0].reply_when == "Personal" &&
            !messages.key.remoteJid.includes("@g.us")
          ? true
          : false;
      if (replyorno === false) return;
      isQuoted = replyRows[0].is_quoted ? true : false;
      if (typeof replyRows[0].reply === "string") {
        replyData = JSON.stringify(replyRows[0].reply);
      } else {
        replyData = replyRows[0].reply;
      }
    }

    // Replace {name} placeholder
    replyData = replyData.replace(/{name}/g, pushName);
    replyData = JSON.parse(replyData);

    if ("type" in replyData) {
      let userJid = sock.user.id.replace(/:\d+/, "");
      if (replyData.type == "audio") {
        return await sock.sendMessage(messages.key.remoteJid, {
          audio: { url: replyData.url },
          ptt: true,
          mimetype: "audio/mpeg",
        });
      }
      const prepared = await prepareMediaMessage(sock, {
        caption: replyData.caption ? replyData.caption : "",
        fileName: replyData.filename,
        media: replyData.url,
        mediatype:
          replyData.type !== "video" && replyData.type !== "image"
            ? "document"
            : replyData.type,
      });
      const message = { ...prepared.message };
      return await sock.sendMessage(
        messages.key.remoteJid,
        {
          forward: {
            key: { remoteJid: userJid, fromMe: true },
            message,
          },
        },
        { quoted: isQuoted ? messages : null }
      );
    } else {
      await sock
        .sendMessage(messages.key.remoteJid, replyData, {
          quoted: isQuoted ? messages : null,
        })
        .catch((err) => {
          console.log(err);
        });
    }
    return true;
  } catch (err) {
    console.log(err);
  }
};

// Send webhook to external URL
async function sendWebhook({ command, bufferImage, from, url, participant }) {
  try {
    const payload = {
      message: command,
      bufferImage: bufferImage == undefined ? null : bufferImage,
      from,
      participant,
    };
    const headers = { "Content-Type": "application/json; charset=utf-8" };
    const response = await axios
      .post(url, payload, { headers })
      .catch(() => false);
    return response.data;
  } catch (err) {
    console.log("error send webhook", err);
    return false;
  }
}

module.exports = { IncomingMessage };
