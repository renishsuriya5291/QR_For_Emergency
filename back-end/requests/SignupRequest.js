import Joi from 'joi';

const schema = Joi.object({
    email: Joi.string().email().required().messages({
        'string.email': 'Email must be a valid email address.',
        'any.required': 'Email is required.'
    }),
    uid: Joi.string().required().messages({
        'any.required': 'Uid is required.'
    }),
    fullName: Joi.string().required().min(3).max(30).messages({
        'any.required': 'Full name is required.',
        'string.min': 'Full name must be at least 3 characters long.',
        'string.max': 'Full name cannot exceed 30 characters.'
    })
});

export default schema;
