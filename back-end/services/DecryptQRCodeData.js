import crypto from "crypto";
import "dotenv/config";
import mysql from "mysql2";
import connection from "../db.config.js";

export default function decryptQRCodeData(userId, rowData, callback) {
    try {
        let decryptedQRCodeData;
        
        let sql = "SELECT email FROM users WHERE id = ?";
        let values = [userId];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, result) => {
            if (error) {
                console.log(error);
            } else {
                const email = result[0].email;

                // Decrypt encryptedData using.
                const decipher = crypto.createDecipheriv(process.env.ENCRYPTION_ALGORITHM, crypto.createHash("sha256").update(email).digest(), Buffer.alloc(16, 0));
                decryptedQRCodeData = decipher.update(rowData.data, "hex", "utf8");
                decryptedQRCodeData += decipher.final("utf8");
            }
            conn.end();
            rowData.data = JSON.parse(decryptedQRCodeData);
            callback(rowData);
        });

    } catch (error) {
        console.log(error);
    }
}
