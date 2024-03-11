import mysql from 'mysql2';
import connection from '../db.config.js';
import crypto from 'crypto';

export default function checkUserIsAuthentic(req, res, next) {
    try {
        const { data } = req.body;

        const decipher = crypto.createDecipheriv(process.env.ENCRYPTION_ALGORITHM, process.env.SECRET_KEY_AES, process.env.SECRET_KEY_AES_IV);
        let sesId = decipher.update(data, 'hex', 'utf8');
        sesId += decipher.final('utf8');

        // First check if the user is already logged in
        let sql = 'SELECT user_id, is_logout, count(*) AS row_count FROM user_signin_logs WHERE session_id = ?';
        let values = [sesId];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });

            } else if (results[0].row_count == 0) {
                res.status(400).send({ "error": { "message": "Bad request for accessing data." } });

            } else if (results[0].is_logout == 1) {
                res.status(400).send({ "error": { "message": "User was logout." } });

            } else {
                // update the user's last login date
                let sql = 'UPDATE user_signin_logs SET updated_at = ? WHERE user_id = ?';
                let values = [new Date(), results[0].user_id];

                conn.execute(sql, values, (error) => {
                    if (error) {
                        res.status(500).send({ "error": { "message": error } });

                    } else {
                        req.body.userId = results[0].user_id;
                        next();
                    }
                });
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
