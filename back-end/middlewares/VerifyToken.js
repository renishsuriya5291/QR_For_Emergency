import jwt from 'jsonwebtoken';
import "dotenv/config";

export default function verifyToken(req, res, next) {

    try {

        let token = req.headers.authorization.split(' ')[1];

        if (!token) {
            res.status(403).send({ "error": { "message": "No token provided." } });
        } else {
            jwt.verify(token, process.env.SECRET_KEY_JWT, (error, result) => {
                if (error) {
                    if (error.name === 'TokenExpiredError') {

                        req.body.data = jwt.decode(token).data;

                        const payload = { data: req.body.data };
                        const secret = process.env.SECRET_KEY_JWT;
                        const expiresIn = '1h'; // token will expire in 1 hour

                        token = jwt.sign(payload, secret, { expiresIn });

                        // Set the token in the response's Authorization header
                        res.setHeader('Authorization', 'Bearer ' + token);
                        next();

                    } else {
                        res.status(401).send({ "error": { "message": "Unauthorized." } });
                    }
                } else {
                    res.setHeader('Authorization', 'Bearer ' + token);
                    req.body.data = result.data;
                    next();
                }
            });
        }

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }

}
