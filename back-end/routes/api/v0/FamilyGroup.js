import express from 'express';
import FamilyGroupController from '../../../controllers/FamilyGroupController.js';
import validateCreateGroupRequest from '../../../middlewares/ValidateCreateGroupRequest.js';

const router = express.Router();

router.route('/')
    .post([validateCreateGroupRequest], FamilyGroupController.store);

router.route('/:id')
    .get(FamilyGroupController.show)
    .put(FamilyGroupController.update)
    .patch(FamilyGroupController.update)
    .delete(FamilyGroupController.destroy);

export default router;
