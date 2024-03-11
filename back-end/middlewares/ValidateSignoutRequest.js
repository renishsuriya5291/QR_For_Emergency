import signoutRequestSchema from '../requests/SignoutRequest.js';

export default function validateSignoutRequest(req, res, next) {

    try {
        // Validate the request body.
        const { error } = signoutRequestSchema.validate(req.body);

        if (error) {
            let errorMessage = error.details[0].message;
            res.status(422).send({ "error1": { "message": errorMessage } });
        } else {
            next();
        }

    } catch (error) {
        res.status(500).send({ "error": { "message": error.message } });
        return;
    }
}
