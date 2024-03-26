import Joi from "joi";

const schema = Joi.object({
    QRCodeName: Joi.string().required().min(3).max(30).messages({
        "any.required": "QRCode name is required.",
        "string.min": "QRCode name must be at least 3 characters long.",
        "string.max": "QRCode name cannot exceed 30 characters."
    }),
    userId: Joi.required().messages({
        "any.required": "User id is required."
    }),
    QRCodeData: Joi.object().required().messages({
        "any.required": "QRCode data is required."
    })
}).unknown(true);

export default schema;
