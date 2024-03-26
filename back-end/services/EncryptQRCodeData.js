import crypto from "crypto";
import "dotenv/config";

export default function encryptQRCodeData(req, res) {

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

                // Encrypt body.QRCodeData using.
                const cipher = crypto.createCipheriv(process.env.ENCRYPTION_ALGORITHM, crypto.createHash("sha256").update(email).digest(), Buffer.alloc(16, 0));
                let encryptedQRCodeData = cipher.update(JSON.stringify(req.body.QRCodeData), "utf8", "hex");
                encryptedQRCodeData += cipher.final("hex");

                req.body.QRCodeData = encryptedQRCodeData;
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
