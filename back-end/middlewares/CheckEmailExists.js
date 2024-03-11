import mysql from 'mysql2';
import connection from '../db.config.js';

export default function checkEmailExists(req, res, next) {
    try {
        const { email } = req.body;

        // First, check if the email already exists
        let sql = 'SELECT count(*) AS row_count FROM users WHERE email = ?';
        let values = [email];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error.message } });

            } else if (results[0].row_count > 0) {
                res.status(422).send({ "error": { "message": "Email already exists." } });

            } else {
                next();
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
