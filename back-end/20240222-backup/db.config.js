const mysql = require('mysql');

// MySQL database connection
const db = mysql.createConnection({
    host: 'localhost',
    port: 3307,
    user: 'root',
    password: '',
    database: 'qr_for_emergency',
});

module.exports = db;
