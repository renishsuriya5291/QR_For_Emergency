import signupRequestSchema from '../requests/SignupRequest.js';

export default function validateSignupRequest(req, res, next) {

    try {
        // Validate the request body.
        const { error } = signupRequestSchema.validate(req.body);
        if (error) {
            let errorMessage = error.details[0].message;
            res.status(400).send({ "error": { "message": errorMessage } });
        } else {
            next();
        }

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}