import express from 'express';
import user from './Users.js';
import auth from './auth/Auth.js';
import verifyToken from '../../../middlewares/VerifyToken.js';
import checkUserIsAuthentic from '../../../middlewares/CheckUserIsAuthentic.js';
import familyGroup from './FamilyGroup.js';
import checkUIDIsCorrect from '../../../middlewares/CheckUIDIsCorrect.js';

const router = express.Router();

/* GET users listing. */
router.get('/', function (req, res, next) {
  res.send('API version 0 works!');
});

router.use('/auth', auth);
router.use('/user/:uid', [verifyToken, checkUserIsAuthentic, checkUIDIsCorrect], user);
router.use('/user/:uid/family-group', [verifyToken, checkUserIsAuthentic, checkUIDIsCorrect], familyGroup);

export default router;
