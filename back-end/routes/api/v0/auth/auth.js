import express from 'express';
import AuthController from './../../../../controllers/AuthController.js';
import validateSignupRequest from '../../../../middlewares/ValidateSignupRequest.js';
import validateSigninRequest from '../../../../middlewares/ValidateSigninRequest.js';
import checkEmailExists from '../../../../middlewares/CheckEmailExists.js';
import checkUserExists from '../../../../middlewares/CheckUserExists.js';
import verifyToken from '../../../../services/VerifyToken.js';
import checkUserLogin from '../../../../middlewares/CheckUserLogin.js';

const router = express.Router();

router.route('/signup').post([validateSignupRequest, checkEmailExists], AuthController.signup);
router.route('/signin').post([validateSigninRequest, checkUserExists], AuthController.signin);

router.route('/foo').post([verifyToken, checkUserLogin], AuthController.verify);

export default router;
