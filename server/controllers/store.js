"use strict";

const fs = require("fs");

const chats = (req, res) => {
  const { token, type, jid } = req.body;

  if (token && type) {
    try {
      // Read the multistore file for the given token
      const data = fs.readFileSync(`credentials/${token}/multistore.js`, {
        encoding: "utf8",
      });
      let json = JSON.parse(data);

      if (type === "chats") {
        json = json["chats"];
      } else if (type === "contacts") {
        json = json["contacts"];
      } else if (type === "messages") {
        if (jid) {
          json = json["messages"][jid];
        } else {
          json = json["messages"];
        }
      } else {
        return res.send({ status: false, message: "Unknown type" });
      }

      if (typeof json === "undefined") {
        return res.send({ status: false, message: "Data Not Found" });
      }

      // If it's an array, reverse it before sending
      return res.send(
        Array.isArray(json) && json.length > 0 ? json.reverse() : json
      );
    } catch (err) {
      if (process.env.NODE_ENV !== "production") {
        console.log(err);
      }
      return res.send({ status: false, error: err });
    }
  }

  res.send({ status: false, error: "wrong parameters" });
};

module.exports = { chats };
