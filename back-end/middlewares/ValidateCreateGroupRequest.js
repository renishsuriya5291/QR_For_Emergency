import createGroupRequest from '../requests/CreateGroupRequest';

export default function validateCreateGroupRequest(req, res, next) {

    try {
        // Validate the request body.
        const { error } = createGroupRequest.validate(req.body);
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
