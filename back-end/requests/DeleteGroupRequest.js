import Joi from 'joi';

const schema = Joi.object({
    userId: Joi.required().messages({
        'any.required': 'User id is required.'
    })
}).unknown(true);

export default schema;
