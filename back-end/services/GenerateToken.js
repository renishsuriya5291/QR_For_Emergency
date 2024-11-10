import crypto from "crypto";
import jwt from "jsonwebtoken";
import "dotenv/config";

export default function generateToken(req, res) {
    try {
        // Generate a random session ID
        req.body.sesId = crypto.randomBytes(32).toString("hex");

        // Encrypt the session ID
        const cipher = crypto.createCipheriv(
            process.env.ENCRYPTION_ALGORITHM,
            Buffer.from(process.env.SECRET_KEY_AES, "utf8"),
            Buffer.from(process.env.SECRET_KEY_AES_IV, "utf8")
        );

        let encrypted = cipher.update(req.body.sesId, "utf8", "hex");
        encrypted += cipher.final("hex");

        // Create a JWT with the encrypted session ID
        const payload = { data: encrypted };
        const secret = process.env.SECRET_KEY_JWT;
        const expiresIn = "1h"; // Token expires in 1 hour

        const token = jwt.sign(payload, secret, { expiresIn });

        // Set the token in the response's Authorization header
        res.header("Authorization", "Bearer " + token);

    } catch (error) {
        console.error("Error generating token:", error);
    }
}
