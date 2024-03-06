import express from 'express';
import AuthController from '../../../../controllers/AuthController.js';
import validateSignupRequest from '../../../../middlewares/ValidateSignupRequest.js';
import validateSigninRequest from '../../../../middlewares/ValidateSigninRequest.js';
import checkEmailExists from '../../../../middlewares/CheckEmailExists.js';
import checkUserExists from '../../../../middlewares/CheckUserExists.js';
import verifyToken from '../../../../middlewares/VerifyToken.js';
import checkUserIsAuthentic from '../../../../middlewares/CheckUserIsAuthentic.js';
import validateSignoutRequest from '../../../../middlewares/ValidateSignoutRequest.js';

const router = express.Router();

router.route('/signup').post([validateSignupRequest, checkEmailExists], AuthController.signup);
router.route('/signin').post([validateSigninRequest, checkUserExists], AuthController.signin);
router.route('/signout').post([verifyToken, checkUserIsAuthentic, validateSignoutRequest], AuthController.signout);

export default router;
