import mysql from 'mysql2';
import { connection } from '../db.config.js';

class UserController {

  index(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });

    const page = req.query.page || 1; // Current page number
    const limit = req.query.limit || 10; // Number of records per page
    const offset = (page - 1) * limit; // Offset calculation

    const sql = `SELECT * FROM users LIMIT ${limit} OFFSET ${offset}`;

    conn.execute(sql, (err, rows, fields) => {
      if (err) {
        res.json({ err });
      } else {
        res.json({ rows });
      }
    });

    conn.end();
  }

  show(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });

    const sql = "SELECT * FROM users WHERE row_id = ?";
    const values = [req.params.id];

    conn.execute(sql, values, (err, rows, fields) => {
      if (err) {
        res.json({ err });
      } else {
        res.json({ "data": rows });
      }
    });

    conn.end();
  }

  store(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });


    const sql = "INSERT INTO users (email, password, phone_no, name) VALUES (?, ?, ?, ?)";
    const values = [req.body.email, req.body.password, req.body.phone_no, req.body.name];

    conn.execute(sql, values, (err, rows, fields) => {
      if (err) {
        res.json({ err });
      } else {
        res.json({ "data": rows });
      }
    });

    conn.end();
  }

  update(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });

    const sql = "UPDATE FROM users WHERE "
    const values = [req.params.id];

    conn.execute(sql, values, (err, rows, fields) => {
      if (err) {
        res.json({ err });
      } else {
        res.json({ "data": rows });
      }
    });

    conn.end();
  }

  destroy(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });

    const sql = "DELETE FROM users WHERE row_id = ?"
    const values = [req.params.id];

    conn.execute(sql, values, (err, rows, fields) => {
      if (err) {
        res.json({ err });
      } else {
        res.json({ "data": rows });
      }
    });

    conn.end();
  }
}

export default new UserController();
