import mysql from "mysql2";
import connection from "../db.config.js";
import encryptQRCodeData from "../services/EncryptQRCodeData.js";

class QRCodeController {

    getAllQRCode(req, res) {
        try {
            const { userId } = req.body;

            let sql = "SELECT * FROM qr_code WHERE user_id = ?";
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
            encryptQRCodeData(req, res);

            const { QRCodeName, QRCodeData, userId } = req.body;

            const QRCodeHash = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

            let sql = "INSERT qr_code(title, hash, data, user_id) VALUES(?, ?, ?, ?)";
            let values = [QRCodeName, QRCodeHash, QRCodeData, userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).json({ "data": { "message": "QRCode generated." } });
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
            const { UserId } = req.body;
            const { QRCodeId } = req.params;

            let sql = "SELECT * FROM qr_code WHERE id = ? AND user_id = ?";
            let values = [QRCodeId, UserId];

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

    updateQRCode(req, res) {
        try {
            encryptQRCodeData(req, res);

            const { title, QRCodeData, userId } = req.body;
            const { QRCodeId } = req.params;

            let sql = "UPDATE qr_code SET title = ?, data = ? WHERE id = ? AND user_id = ?";
            let values = [title, QRCodeData, QRCodeId, userId];

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
            res.status(500).send({ "error": { "message": error } });
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
}

export default new QRCodeController();
