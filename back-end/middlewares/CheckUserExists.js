import mysql from "mysql2";
import connection from "../db.config.js";

export default function checkUserExists(req, res, next) {
    try {
        const { uid } = req.body;

        let sql = "SELECT id, count(*) AS row_count FROM users WHERE uid = ?";
        let values = [uid];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });
            } else if (results[0].row_count == 0) {
                res.status(404).send({ "error": { "message": "User not exists." } });
            } else {
                req.body.userId = results[0].id;
                next();
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
