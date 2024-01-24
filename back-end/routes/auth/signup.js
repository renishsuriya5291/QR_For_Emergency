const express = require('express');
const signupRouter = express.Router();
const db = require('./../../db.config')

// Define a post signup route on the router
signupRouter.post('/', (req, res) => {

    // Connect to the database
    db.connect(err => {
        if (err) {
            console.error('Error connecting to MySQL:', err);
        } else {
            console.log('Connected to MySQL database');
        }
    });

    // Close the connection when you're done
    db.end(err => {
        if (err) {
            console.error('Error closing MySQL connection:', err);
        } else {
            console.log('MySQL connection closed');
        }
    });
    res.send(req.body);
});

module.exports = signupRouter;
