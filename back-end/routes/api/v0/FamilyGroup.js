import express from 'express';
import FamilyGroupController from '../../../controllers/FamilyGroupController.js';
import validateCreateGroupRequest from '../../../middlewares/ValidateCreateGroupRequest.js';
import validateUpdateGroupRequest from '../../../middlewares/validateUpdateGroupRequest.js';
import validateDeleteGroupRequest from '../../../middlewares/validateDeleteGroupRequest.js';
import checkUserInGroup from '../../../middlewares/CheckUserInGroup.js';

const router = express.Router();

router.route('/')
    .get(FamilyGroupController.getAllGroup)
    .post([validateCreateGroupRequest], FamilyGroupController.createOneGroup);

router.route('/:groupId')
    .get(FamilyGroupController.getOneGroup)
    .put([validateUpdateGroupRequest, checkUserInGroup], FamilyGroupController.updateGroup)
    .delete([validateDeleteGroupRequest], FamilyGroupController.deleteGroup);

export default router;
