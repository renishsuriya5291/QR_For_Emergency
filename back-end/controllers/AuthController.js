import mysql from 'mysql2';
import connection from '../db.config.js';
import generateToken from '../services/GenerateToken.js';

class AuthController {

    signup(req, res) {
        try {
            const { email, uid, fullName } = req.body;

            let sql = 'INSERT INTO users (email, uid, full_name) VALUES (?, ?, ?)';
            let values = [email, uid, fullName];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error } });
                } else {
                    // All done successfully and send the response.
                    res.status(201).send({ "data": { "message": 'User created.' } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    signin(req, res) {
        try {
            // Generate token and put in response header.
            generateToken(req, res);

            const { userId, ipAddress, userAgent, sesId } = req.body;

            let sql = 'INSERT INTO user_signin_logs (user_id, ip_address, user_agent, session_id) VALUES (?, ?, ?, ?)';
            let values = [userId, ipAddress, userAgent, sesId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(201).send({ "data": { "message": 'Signin log created.' } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error.message } });
            return;
        }
    }

    signout(req, res) {
        try {
            const { userId } = req.body;

            let sql = 'UPDATE user_signin_logs SET is_logout = 1, updated_at = ? WHERE user_id = ? AND is_logout = 0';
            let values = [new Date(), userId];

            const conn = mysql.createConnection(connection);

            conn.execute(sql, values, (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(200).send({ "data": { "message": 'User logout.' } });
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error.message } });
            return;
        }
    }

}

export default new AuthController();
