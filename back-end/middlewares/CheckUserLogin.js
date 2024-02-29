import mysql from 'mysql2';
import connection from '../db.config.js';
import crypto from 'crypto';

export default function checkUserLogin(req, res, next) {
    try {
        const { data } = req.body;

        const decipher = crypto.createDecipheriv(process.env.ENCRYPTION_ALGORITHM, process.env.SECRET_KEY_AES, process.env.SECRET_KEY_AES_IV);
        let sesId = decipher.update(data, 'hex', 'utf8');
        sesId += decipher.final('utf8');

        const conn = mysql.createConnection(connection);

        // First check if the user is already logged in
        let sql = 'SELECT user_id, is_logout, count(*) AS row_count FROM user_signin_logs WHERE session_id = ?';
        conn.execute(sql, [sesId], (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });

            } else if (results[0].row_count == 0) {
                res.status(401).send({ "error": { "message": "Unauthorized" } });

            } else if (results[0].is_logout == 1) {
                res.status(401).send({ "error": { "message": "User logout" } });

            } else {
                // update the user's last login date
                sql = 'UPDATE user_signin_logs SET last_request_time = ?, updated_at = ? WHERE user_id = ?';
                conn.execute(sql, [new Date(), new Date(), results[0].user_id], (error, results) => {
                    if (error) {
                        res.status(500).send({ "error": { "message": error.message } });
                    } else {
                        next();
                    }
                });
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
