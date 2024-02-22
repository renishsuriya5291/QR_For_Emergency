import express from 'express';
import users from './v0/users.js';

const router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
  res.send('API version 0 works!');
});

router.use('/users', users);

export default router;
