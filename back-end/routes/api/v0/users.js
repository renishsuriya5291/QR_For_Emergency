import express from 'express';
import UserController from '../../../controllers/UserController.js';

const router = express.Router();

// router.route('/')
//     .get(UserController.index)
//     .post(UserController.store);

router.route('/:id')
    .get(UserController.show)
    .put(UserController.update)
    .patch(UserController.update)
    .delete(UserController.destroy);

export default router;
