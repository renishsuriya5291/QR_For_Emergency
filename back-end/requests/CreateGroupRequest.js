import Joi from 'joi';

const schema = Joi.object({
    groupName: Joi.string().required().min(3).max(30).messages({
        'any.required': 'Group name is required.',
        'string.min': 'Group name must be at least 3 characters long.',
        'string.max': 'Group name cannot exceed 30 characters.'
    }),
    userId: Joi.required().messages({
        'any.required': 'User id is required.'
    })
}).unknown(true);

export default schema;
