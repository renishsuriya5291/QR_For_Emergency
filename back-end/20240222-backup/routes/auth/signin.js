const express = require('express');
const signupRouter = express.Router();

// Define a post signup route on the router
signupRouter.post('/', (req, res) => {
    res.send('signin works!');
});

module.exports = signupRouter;
