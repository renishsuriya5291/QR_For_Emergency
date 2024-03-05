import express from 'express';
import users from './Users.js';
import auth from './auth/Auth.js';
import verifyToken from '../../../services/VerifyToken.js';
import checkUserIsAuthentic from '../../../middlewares/CheckUserIsAuthentic.js';
import familyGroup from './FamilyGroup.js';

const router = express.Router();

/* GET users listing. */
router.get('/', function (req, res, next) {
  res.send('API version 0 works!');
});

router.use('/auth', auth);
router.use('/users', [verifyToken, checkUserIsAuthentic], users);
router.use('/family-group',[verifyToken, checkUserIsAuthentic], familyGroup);

export default router;
