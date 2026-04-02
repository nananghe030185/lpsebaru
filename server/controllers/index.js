"use strict";

const { formatReceipt } = require("../lib/helper");
const wa = require("../whatsapp");

// Create WhatsApp instance
const createInstance = async (req, res) => {
  const { token } = req.body;
  if (token) {
    try {
      const result = await wa.connectToWhatsApp(token, req.io);
      const status = result?.status;
      const qrcode = result?.qrcode;
      const message = result?.message;
      return res.send({
        status: status ?? "processing",
        qrcode: qrcode,
        message: message ? message : "Processing",
      });
    } catch (err) {
      console.log(err);
      return res.send({ status: false, error: err });
    }
  }
  res.status(403).end("Token needed");
};

// Send text message
const sendText = async (req, res) => {
  const { token, number, text } = req.body;
  if (token && number && text) {
    const result = await wa.sendText(token, number, text);
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameter" });
};

// Send media message
const sendMedia = async (req, res) => {
  const { token, number, type, url, caption, ptt, filename } = req.body;
  if (token && number && type && url) {
    const result = await wa.sendMedia(
      token,
      number,
      type,
      url,
      caption ?? "",
      ptt,
      filename
    );
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameter" });
};

// Send button message
const sendButtonMessage = async (req, res) => {
  const { token, number, button, message, footer, image } = req.body;
  const buttons = JSON.parse(button);
  if (token && number && button && message) {
    const result = await wa.sendButtonMessage(
      token,
      number,
      buttons,
      message,
      footer,
      image
    );
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameter" });
};

// Send template message
const sendTemplateMessage = async (req, res) => {
  const { token, number, button, text, footer, image } = req.body;
  if (token && number && button && text && footer) {
    const result = await wa.sendTemplateMessage(
      token,
      number,
      JSON.parse(button),
      text,
      footer,
      image
    );
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameterrss" });
};

// Send list message
const sendListMessage = async (req, res) => {
  const { token, number, list, text, footer, title, buttonText } = req.body;
  if (token && number && list && text && title && buttonText) {
    const result = await wa.sendListMessage(
      token,
      number,
      JSON.parse(list),
      text,
      footer ?? "",
      title,
      buttonText
    );
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameterr" });
};

// Send poll message
const sendPoll = async (req, res) => {
  const { token, number, name, options, countable } = req.body;
  if (token && number && name && options && countable) {
    const result = await wa.sendPollMessage(
      token,
      number,
      name,
      JSON.parse(options),
      countable
    );
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your parameterrss" });
};

// Fetch groups
const fetchGroups = async (req, res) => {
  const { token } = req.body;
  if (token) {
    const result = await wa.fetchGroups(token);
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your whatsapp connection" });
};

// Delete credentials/session
const deleteCredentials = async (req, res) => {
  const { token } = req.body;
  if (token) {
    const result = await wa.deleteCredentials(token);
    return handleResponSendMessage(result, res);
  }
  res.send({ status: false, message: "Check your whatsapp connection" });
};

// Helper to handle response for send message
const handleResponSendMessage = (result, res, errorMsg = null) => {
  if (result) return res.send({ status: true, data: result });
  return res.send({
    status: false,
    message: errorMsg ?? "Check your parameter",
  });
};

// Check if number exists
const checkNumber = async (req, res) => {
  const { token, number } = req.body;
  if (token && number) {
    const result = await wa.isExist(token, number);
    console.log(result);
    return res.send({ status: true, active: result });
  }
  res.send({ status: false, message: "Check your parameter" });
};

// Logout device
const logoutDevice = async (req, res) => {
  const { token } = req.body;
  if (token) {
    const result = await wa.deleteCredentials(token);
    return res.send(result);
  }
  return res.send({ status: false, message: "Check your whatsapp connection" });
};

module.exports = {
  createInstance,
  sendText,
  sendMedia,
  sendButtonMessage,
  sendTemplateMessage,
  sendListMessage,
  deleteCredentials,
  fetchGroups,
  sendPoll,
  logoutDevice,
  checkNumber,
};
