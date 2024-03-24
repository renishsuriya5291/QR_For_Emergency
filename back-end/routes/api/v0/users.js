import express from 'express';
import UserController from '../../../controllers/UserController.js';
import validateUpdateUserRequest from '../../../middlewares/ValidateUpdateUserRequest.js';

const router = express.Router();

router.route('/')
    .get(UserController.show)
    .put([validateUpdateUserRequest], UserController.update)
    .delete(UserController.destroy)

export default router;
