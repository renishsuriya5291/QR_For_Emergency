import signinRequestSchema from '../requests/SigninRequest.js';

export default function validateSigninRequest(req, res, next) {

    try {
        // Validate the request body.
        const { error } = signinRequestSchema.validate(req.body);

        if (error) {
            let errorMessage = error.details[0].message;
            res.status(422).send({ "error": { "message": errorMessage } });

        } else {
            next();
        }

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
