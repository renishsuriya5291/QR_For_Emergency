import Joi from 'joi';

const schema = Joi.object({
    email: Joi.string().email().required().messages({
        'string.email': 'Email must be a valid email address.',
        'any.required': 'Email is required.'
    }),
    userId: Joi.required().messages({
        'any.required': 'User id is required.'
    }),
    action: Joi.string().valid('Add', 'Remove').required().messages({
        'any.required': 'Action is required.',
        'any.only': 'Action must be either Add or Remove.'
    })
}).unknown(true);

export default schema;
