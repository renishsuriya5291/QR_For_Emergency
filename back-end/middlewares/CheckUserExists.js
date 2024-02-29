import mysql from 'mysql2';
import connection from '../db.config.js';

export default function checkUserExists(req, res, next) {
    try {
        const { uid } = req.body;

        const conn = mysql.createConnection(connection);

        // First, check if the user exists.
        const sql = 'SELECT id, count(*) AS row_count FROM users WHERE uid = ?';
        conn.execute(sql, [uid], (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": err.message } });

                // If the user not exists, send an error message.
            } else if (results[0].row_count == 0) {
                res.status(404).send({ "error": { "message": "User not exists" } });
                return;

                // Add user's id in req object
            } else {
                req.body.id = results[0].id;
                next();
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
