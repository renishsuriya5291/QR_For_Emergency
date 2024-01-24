const express = require('express');
const router = express.Router();

// Import the router
const signupRouter = require('./Routes/auth/signup');
const signinRouter = require('./Routes/auth/signin');

// Define a signupRouter route on the router
router.use("/signup", signupRouter)

// Define a signinRouter route on the router
router.use("/signin", signinRouter)

// Export the router to use in other files
module.exports = router;
