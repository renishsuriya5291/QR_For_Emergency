import Joi from 'joi';

const schema = Joi.object({
    fullName: Joi.string().required().min(3).max(30).messages({
        'any.required': 'Full name is required.',
        'string.min': 'Full name must be at least 3 characters long.',
        'string.max': 'Full name cannot exceed 30 characters.'
    }),
    phoneNo: Joi.string().required().min(10).max(10).messages({
        'any.required': 'Phone number is required.',
        'string.min': 'Phone number must be 10 characters long.',
        'string.max': 'Phone number must be 10 characters long.'
    }),
    photo: Joi.string().required().messages({
        'any.required': 'Photo is required.',
        'string.empty': 'Photo cannot be an empty string.'
    }),
}).unknown(true);

export default schema;
