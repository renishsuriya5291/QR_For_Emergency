import mysql from "mysql2";
import connection from "../db.config.js";
import decryptQRCodeData from "../services/DecryptQRCodeData.js";
import QRCode from "qrcode";
class QRCodeController {

    getAllQRCode(req, res) {
        try {
            const { userId } = req.body;

            let sql = "SELECT id, title FROM qr_code WHERE user_id = ?";
            let values = [userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error, rows) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).json({ "data": rows });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    createOneQRCode(req, res) {
        try {
            const { QRCodeName, QRCodeData, userId } = req.body;

            const QRCodeHash = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

            let sql = "INSERT qr_code(title, hash, data, user_id) VALUES(?, ?, ?, ?)";
            let values = [QRCodeName, QRCodeHash, QRCodeData, userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).json({ "data": { "message": "QRCode generated.", "Authorization": req.headers.authorization } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    getOneQRCode(req, res) {
        try {
            const { userId } = req.body;
            const { QRCodeId } = req.params;

            let sql = "SELECT * FROM qr_code WHERE id = ? AND user_id = ?";
            let values = [QRCodeId, userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error, rows) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    if (rows.length == 0) {
                        res.status(404).json({ "error": { "message": "QRCode not found." } })
                    } else {
                        decryptQRCodeData(req.body.userId, rows[0], (decryptedData) => {
                            res.status(200).json({ "data": decryptedData });
                        });
                    }
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error.message } });
            return;
        }
    }

    updateQRCode(req, res) {
        try {
            const { QRCodeName, QRCodeData, userId } = req.body;
            const { QRCodeId } = req.params;

            let sql = "UPDATE qr_code SET title = ?, data = ? WHERE id = ? AND user_id = ?";
            let values = [QRCodeName, QRCodeData, QRCodeId, userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).json({ "data": { "message": "QRCode updated." } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error.message } });
            return;
        }
    }

    deleteQRCode(req, res) {
        try {
            const { userId } = req.body;
            const { QRCodeId } = req.params;

            let sql = "DELETE FROM qr_code WHERE id = ? AND user_id = ?";
            let values = [QRCodeId, userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).json({ "data": { "message": "QRCode deleted." } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    show(req, res) {
        try {
            const { QRCodeHash } = req.params;

            let sql = "SELECT data, user_id FROM qr_code INNER JOIN users ON qr_code.user_id = users.id WHERE hash = ?";
            let values = [QRCodeHash];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error, rows) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    if (rows.length == 0) {
                        res.status(404).json({ "error": { "message": "QRCode not found." } })
                    } else {
                        decryptQRCodeData(rows[0].user_id, rows[0], (decryptedData) => {
                            res.status(200).json({ "data": decryptedData.data });
                        });
                    }
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    getContactDetails(req, res) {
        try {
            const { QRCodeHash } = req.params;

            let sql = "SELECT email, phone_no FROM users WHERE id IN(SELECT user_id FROM user_to_group WHERE group_id IN(SELECT group_id FROM user_to_group WHERE user_id IN(SELECT user_id FROM qr_code WHERE hash = ?)))";
            let values = [QRCodeHash];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error, rows) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    if (rows.length == 0) {
                        res.status(404).json({ "error": { "message": "QRCode not found." } })
                    } else {

                        res.status(200).json({ "data": rows });
                    }
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    async getQRCode(req, res) {
        const { url } = req.body;

        if (!url) {
            return res.status(400).send('Please provide a url query parameter.');
        }
        try {
            // Generate the QR code as a PNG buffer
            const qrCodeBuffer = await QRCode.toBuffer(url);

            // Set response headers to indicate an image response
            res.setHeader('Content-Type', 'image/png');
            res.send(qrCodeBuffer);
        } catch (error) {
            console.error(error);
            res.status(500).send('Error generating QR code.');
        }
    }
}

export default new QRCodeController();
