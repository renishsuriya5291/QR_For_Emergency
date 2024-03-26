import deleteQRCodeRequest from "../requests/DeleteQRCodeRequest.js";

export default function validateDeleteQRCodeRequest(req, res, next) {

    try {
        const { error } = deleteQRCodeRequest.validate(req.body);
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
