import mysql from 'mysql2';
import connection from '../db.config.js';
import generateToken from '../services/GenerateToken.js';
import verifyToken from '../services/VerifyToken.js';

class AuthController {

    signup(req, res) {

        try {
            const conn = mysql.createConnection(connection);

            const { email, uid, fullName } = req.body;

            let sql = 'INSERT INTO users (email, uid, full_name) VALUES (?, ?, ?)';
            conn.execute(sql, [email, uid, fullName], (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error } });
                } else {
                    // All done successfully and send the response.
                    res.status(201).send('User created successfully');
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error } });
            return;
        }
    }

    signin(req, res, next) {
        try {

            const conn = mysql.createConnection(connection);

            // Generate token and put in response header.
            generateToken(req, res);

            const { id, ipAddress, userAgent, sesId } = req.body;

            let sql = 'INSERT INTO user_signin_logs (user_id, ip_address, user_agent, session_id) VALUES (?, ?, ?, ?)';
            conn.execute(sql, [id, ipAddress, userAgent, sesId], (error) => {
                if (error) {
                    res.status(500).send({ "error": { "message": error.message } });
                } else {
                    res.status(201).send('Signin log created successfully');
                }
                conn.end();
            });

        } catch (error) {
            res.status(500).send({ "error": { "message": error.message } });
            return;
        }
    }

    verify(req, res, next) {
        res.status(200).send('Verified');
    }
}

export default new AuthController();
