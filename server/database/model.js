const { dbQuery } = require("./index");
const cache = require("./../lib/cache");
const myCache = cache.myCache;

// Check if an "Equal" command exists for a device and keyword
const isExistsEqualCommand = async (device, keyword) => {
  if (myCache.has(device + keyword)) return myCache.get(device + keyword);

  // Find device by keyword
  let deviceRows = await dbQuery(
    `SELECT * FROM devices WHERE body = '${keyword}' LIMIT 1`
  );
  if (deviceRows.length === 0) return [];

  let deviceId = deviceRows[0]["id"];

  // Find active autoreply for this device and keyword
  let replyRows = await dbQuery(
    `SELECT * FROM autoreplies WHERE keyword = "${device}" AND type_keyword = 'Equal' AND device_id = ${deviceId} AND status = 'Active' LIMIT 1`
  );
  if (replyRows.length === 0) return [];

  myCache.set(device + keyword, replyRows);
  return replyRows;
};

// Check if a "Contain" command exists for a device and keyword
const isExistsContainCommand = async (device, keyword) => {
  if (myCache.has("contain" + device + keyword))
    return myCache.get("contain" + device + keyword);

  // Find device by keyword
  let deviceRows = await dbQuery(
    `SELECT * FROM devices WHERE body = '${keyword}' LIMIT 1`
  );
  if (deviceRows.length === 0) return [];

  let deviceId = deviceRows[0]["id"];

  // Find active autoreply for this device and keyword (contain)
  let replyRows = await dbQuery(
    `SELECT * FROM autoreplies WHERE LOCATE(keyword, "${device}") > 0 AND type_keyword = 'Contain' AND device_id = ${deviceId} AND status = 'Active' LIMIT 1`
  );
  if (replyRows.length === 0) return [];

  myCache.set("contain" + device + keyword, replyRows);
  return replyRows;
};

// Get webhook URL for a device
const getUrlWebhook = async (keyword) => {
  if (myCache.has("webhook" + keyword)) return myCache.get("webhook" + keyword);

  let url = null;
  let rows = await dbQuery(
    `SELECT webhook FROM devices WHERE body = '${keyword}' LIMIT 1`
  );
  if (rows.length > 0) url = rows[0]["webhook"];

  myCache.set("webhook" + keyword, url);
  return url;
};

module.exports = {
  isExistsEqualCommand,
  isExistsContainCommand,
  getUrlWebhook,
};
