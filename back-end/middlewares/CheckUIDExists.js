import mysql from "mysql2";
import connection from "../db.config.js";

export default function checkUIDExists(req, res, next) {
    try {
        const { uid } = req.body;

        // First, check if the uid already exists
        let sql = "SELECT count(*) AS row_count FROM users WHERE uid = ?";
        let values = [uid];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });
            } else if (results[0].row_count > 0) {
                res.status(422).send({ "error": { "message": "UID already exists." } });
            } else {
                next();
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
