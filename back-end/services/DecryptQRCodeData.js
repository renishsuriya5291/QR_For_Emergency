import crypto from "crypto";
import "dotenv/config";

export default function decryptQRCodeData(req, res) {

    try {
        const { userId } = req.body;

        let sql = "SELECT email FROM user WHERE id = ?";
        let values = [userId];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });
            } else {
                const email = result[0].email;

                // Decrypt encryptedData using.
                const decipher = crypto.createDecipheriv(process.env.ENCRYPTION_ALGORITHM, crypto.createHash("sha256").update(email).digest(), Buffer.alloc(16, 0));
                let decryptedQRCodeData = decipher.update(QRCodeData, "hex", "utf8");
                decryptedQRCodeData += decipher.final("utf8");

                req.body.QRCodeData = JSON.parse(decryptedQRCodeData);
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
