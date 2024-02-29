import Joi from 'joi';

const schema = Joi.object({
    ipAddress: Joi.string().required().messages({
        'any.required': 'ip address is required.'
    }),
    userAgent: Joi.string().required().messages({
        'any.required': 'User agent is required.'
    }),
    uid: Joi.string().required().messages({
        'any.required': 'Uid is required.'
    }),
});

export default schema;