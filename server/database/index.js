import { Client } from "pg";
import dotenv from "dotenv";

dotenv.config();

export const db = new Client({
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    database: process.env.DB_DATABASE,
    password: process.env.DB_PASSWORD,
    port: process.env.DB_PORT,
});

async function connectDB() {
    try {
        await db.connect();
    } catch (error) {
        console.log("Database connection error: ", error);
    }
}
connectDB();

export const setStatus = (device, status) => {
    try {
        let query = `UPDATE perangkats SET status = '${status}' WHERE number = '${device}' `;
        db.query(query);
        return true;
    } catch (error) {
        return false;
    }
};

export const inboxMessage = (sender, message) => {
    try {
        const date = new Date();
        const tgl = date.toISOString().slice(0, 19).replace("T", " ");
        let query = `INSERT INTO inboxes (status, sender, message, channel, created_at,updated_at) VALUES (true, '${sender}', '${message}', 'whatsapp','${tgl}','${tgl}') `;
        db.query(query);
        return true;
    } catch (error) {
        return false;
    }
};

export function dbQuery(query) {
    return new Promise((data) => {
        db.query(query, (err, res) => {
            if (err) throw err;
            try {
                data(res);
            } catch (error) {
                data({});
                //throw error;
            }
        });
    });
}

// export default { db, dbQuery, setStatus };

// EXPORT
