import mysql from 'mysql2';
import connection from '../db.config.js';

class FamilyGroupController {

  index(req, res, next) { }

  store(req, res, next) {
    try {
      const conn = mysql.createConnection(connection);

      let { name, user_id} = req.body;

      let sql = "INSERT family_group(name, group_created_by) VALUES(?, ?)";
      let values = [name, user_id];
      conn.execute(sql, values, (error, rows, fields) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });
          return;
        } else {
          res.status(200).json({ "data": rows[0] });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }

  show(req, res, next) {
    try {
      const conn = mysql.createConnection(connection);

      let sql = "SELECT email, phone_no, full_name, photo FROM users WHERE uid = ?";
      let values = [req.params.id];
      conn.execute(sql, values, (error, rows, fields) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });
          return;
        } else {
          res.status(200).json({ "data": rows[0] });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }

  update(req, res, next) {
    const conn = mysql.createConnection(connection);

    const { phone_no, full_name, photo } = req.body;

    let sql = "UPDATE users SET phone_no = ?, full_name = ?, photo = ?, updated_at = ? WHERE uid = ?"
    let values = [phone_no, full_name, photo, req.params.id, new Date()];

    conn.execute(sql, values, (error, rows) => {
      if (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
      } else {
        res.status(200).json({ "data": rows });
      }
      conn.end();
    });

  }

  destroy(req, res, next) {
    const conn = mysql.createConnection(connection);
    conn.addListener('error', (err) => {
      res.json({ "Error": err });
    });

    const sql = "DELETE FROM users WHERE uid = ?"
    const values = [req.params.id];

    conn.execute(sql, values, (error, rows) => {
      if (error) {
        res.status(500).send({ "error": { "message": error } });
        return;
      } else {
        res.status(200).json({ "data": rows });
      }
      conn.end();
    });
  }
}

export default new FamilyGroupController();
