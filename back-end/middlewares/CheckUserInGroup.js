import mysql from 'mysql2';
import connection from '../db.config.js';

export default function checkUserInGroup(req, res, next) {
    try {
        req.body.userId1 = undefined;
        req.body.isInGroup = undefined;

        const { email } = req.body;
        const { groupId } = req.params;

        let sql = 'SELECT count(*) AS row_count, users.id AS id FROM users INNER JOIN user_to_group ON users.id = user_to_group.user_id WHERE users.email = ? AND user_to_group.group_id = ?';
        let values = [email, groupId];

        const conn = mysql.createConnection(connection);

        conn.execute(sql, values, (error, results) => {
            if (error) {
                res.status(500).send({ "error": { "message": error } });

            } else {
                if (results[0].row_count > 0) {
                    req.body.isInGroup = true;
                    req.body.userId1 = results[0].id;
                    if (req.body.userId == req.body.userId1) {
                        res.status(400).send({ "error": { "message": "You can't add or remove your email." } });
                    } else if (req.body.userId1 != undefined) {
                        next();
                    }

                } else {
                    let sql = "SELECT id FROM users WHERE email = ?";
                    let values = [email];

                    conn.execute(sql, values, (error, results) => {
                        if (error) {
                            res.status(500).send({ "error": { "message": error } });

                        } else if (!results[0] || !results[0].id) {
                            res.status(404).send({ "error": { "message": "Email not found." } });

                        } else {
                            req.body.isInGroup = false;
                            req.body.userId1 = results[0].id;
                            if (req.body.userId == req.body.userId1) {
                                res.status(400).send({ "error": { "message": "You can't add or remove your email." } });
                            } else if (req.body.userId1 != undefined) {
                                next();
                            }
                        }
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
