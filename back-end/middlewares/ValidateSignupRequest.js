import signupRequestSchema from "../requests/SignupRequest.js";

export default function validateSignupRequest(req, res, next) {

    try {
        const { error } = signupRequestSchema.validate(req.body);

        if (error) {
            let errorMessage = error.details[0].message;
            res.status(422).send({ "error": { "message": errorMessage } });
        } else {
            next();
        }

    } catch (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
    }
}
