import crypto from 'crypto';
import jwt from 'jsonwebtoken';
import "dotenv/config";

export default function generateToken(req, res) {

    try {
        req.body.sesId = crypto.randomBytes(32).toString('hex');

        // Encrypt the sesId
        const cipher = crypto.createCipheriv(process.env.ENCRYPTION_ALGORITHM, process.env.SECRET_KEY_AES, process.env.SECRET_KEY_AES_IV);
        let encrypted = cipher.update(req.body.sesId, 'utf8', 'hex');
        encrypted += cipher.final('hex');

        const payload = { data: encrypted };
        const secret = process.env.SECRET_KEY_JWT;
        const expiresIn = '1h'; // token will expire in 1 hour

        const token = jwt.sign(payload, secret, { expiresIn });

        // Set the token in the response's Authorization header
        res.setHeader('Authorization', 'Bearer ' + token);
    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
