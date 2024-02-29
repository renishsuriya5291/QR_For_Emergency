import express from 'express';
import users from './users.js';
import auth from './auth/auth.js';

const router = express.Router();

/* GET users listing. */
router.get('/', function (req, res, next) {
  res.send('API version 0 works!');
});

router.use('/users', users);
router.use('/auth', auth);

export default router;
