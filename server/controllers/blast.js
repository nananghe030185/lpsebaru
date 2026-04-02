// blast.js — deobfuscated

const { dbQuery } = require("../database");
const { formatReceipt /*, prepareMediaMessage */ } = require("../lib/helper");
const wa = require("../whatsapp");
const fs = require("fs");

// Tracks active blast jobs per campaign_id to avoid concurrent runs
const inProgress = {};

// --- Helpers ---------------------------------------------------------------

/**
 * Update a blast row's status for (campaign_id, receiver).
 */
async function updateStatus(campaignId, receiver, status) {
  await dbQuery(
    "UPDATE blasts SET status = '" +
      status +
      "' WHERE receiver = '" +
      receiver +
      "' AND campaign_id = '" +
      campaignId +
      "'"
  );
}

/**
 * Return true if there's a blast row still pending for (campaign_id, receiver).
 */
async function checkBlast(campaignId, receiver) {
  const rows = await dbQuery(
    "SELECT status FROM blasts WHERE receiver = '" +
      receiver +
      "' AND campaign_id = '" +
      campaignId +
      "'"
  );
  return rows.length > 0 && rows[0].status === "pending";
}

/**
 * Sleep helper
 */
const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

// --- Main export -----------------------------------------------------------

/**
 * Send a batch ("blast") of WhatsApp messages.
 * Expects req.body.data to be JSON like:
 * {
 *   "sender": "<device_id_or_jid>",
 *   "campaign_id": "<id>",
 *   "delay": <seconds>,
 *   "type": "text" | "media",
 *   "data": [
 *     // for text
 *     { "receiver": "<phone>", "message": "..." },
 *     // or for media
 *     { "receiver": "<phone>", "message": "...", "data": "{\"type\":\"image\",\"url\":\"http...\",\"filename\":\"file.jpg\",\"caption\":\"...\"}" }
 *   ]
 * }
 */
async function sendBlastMessage(req, res) {
  // Parse input
  const payload = JSON.parse(req.body.data);
  const items = payload.data;
  const campaignId = payload.campaign_id;

  // Prevent concurrent runs for the same campaign
  if (inProgress[campaignId]) {
    console.log(
      "still any progress in campaign id " + campaignId + ", request canceled."
    );
    return res.send({ status: "in_progress" });
  }

  inProgress[campaignId] = true;
  console.log("progress campaign ID : " + campaignId + " started");
  res.send({ status: "in_progress" });

  // Worker
  const run = async () => {
    for (let i in items) {
      const it = items[i];

      // Delay between sends
      const delaySeconds = payload.delay;
      await sleep(delaySeconds * 1000);

      // Basic validation
      if (!payload.sender || !it.receiver || !it.message) {
        console.log("wrong data, progress canceled!");
        continue;
      }

      // Only send if DB row is still pending
      const stillPending = await checkBlast(campaignId, it.receiver);
      if (!stillPending) {
        console.log("no pending, not send!");
        continue;
      }

      // Check WA existence
      try {
        const exists = await wa.isExist(
          payload.sender,
          formatReceipt(it.receiver)
        );
        if (!exists) {
          await updateStatus(campaignId, it.receiver, "failed");
          continue;
        }
      } catch (err) {
        console.log("Error in wa.isExist: ", err);
        await updateStatus(campaignId, it.receiver, "failed");
        continue;
      }

      // Send message (text or media)
      try {
        let ok = false;

        if (payload.type === "media") {
          // it.data is a JSON string: { type, url, filename, caption }
          const media = JSON.parse(it.data);
          ok = await wa.sendMedia(
            payload.sender,
            it.receiver,
            media.type,
            media.url,
            media.filename,
            0,
            media.caption
          );
        } else {
          ok = await wa.sendMessage(payload.sender, it.receiver, it.message);
        }

        const status = ok ? "success" : "failed";
        await updateStatus(campaignId, it.receiver, status);
      } catch (err) {
        console.log(err);

        // Transient error: server busy — retry this item after 5s
        if (String((err && err.message) || err).includes("503")) {
          console.log(
            "Server is busy, waiting for 5 seconds before retrying..."
          );
          await sleep(5000);
          // Decrement index to retry the same item in the next iteration
          i--;
        } else {
          await updateStatus(campaignId, it.receiver, "error");
        }
      }
    }

    // Done
    delete inProgress[campaignId];
  };

  // Start worker and ensure cleanup on crash
  run().catch((e) => {
    console.log("Error in send operation: ", e);
    delete inProgress[campaignId];
  });
}

module.exports = { sendBlastMessage };
