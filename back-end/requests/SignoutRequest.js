import Joi from 'joi';

const schema = Joi.object({
    user_id: Joi.string().required().messages({
        'any.required': 'User id is required.'
    })
});

export default schema;
