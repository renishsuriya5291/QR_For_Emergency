import mysql from 'mysql2';
import connection from '../db.config.js';

export default function checkUIDIsCorrect(req, res, next) {
    try {
        const { uid } = req.params;

        let sql = 'SELECT id FROM users WHERE uid = ?';
        let values = [uid];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error } });

            } else if (!results[0] || !results[0].id) {
                res.status(401).send({ "error": { "message": "Unauthorized to access other user's data." } });

            } else if (results[0].id == req.body.userId) {
                req.body.uid = req.params.uid;
                next();
            } else {
                res.status(401).send({ "error": { "message": "Unauthorized to access other user's data." } });
            }
            conn.end();
        });

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
