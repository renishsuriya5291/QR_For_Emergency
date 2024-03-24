import mysql from 'mysql2';
import connection from '../db.config.js';

class UserController {

  show(req, res) {
    try {
      const { uid } = req.body;

      let sql = "SELECT email, phone_no, full_name, photo FROM users WHERE uid = ?";
      let values = [uid];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error, rows) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else {
          res.status(200).json({ "data": rows });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }

  update(req, res) {
    try {
      const { phoneNo, fullName, photo, uid } = req.body;

      let sql = "UPDATE users SET phone_no = ?, full_name = ?, photo = ? WHERE uid = ?";
      let values = [phoneNo, fullName, photo, uid];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else {
          res.status(200).json({ "data": { "message": "Information updated." } });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }

  }

  destroy(req, res) {
    try {
      const { uid } = req.body;

      let sql = "DELETE FROM users WHERE uid = ?";
      let values = [uid];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else {
          res.status(200).json({ "data": { "message": "Bye." } });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }
}

export default new UserController();
