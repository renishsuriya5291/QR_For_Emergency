import mysql from 'mysql2';
import connection from '../db.config.js';

class FamilyGroupController {

  getAllGroup(req, res) {
    try {
      const { userId } = req.body;

      let sql = "SELECT family_group.id, family_group.name, family_group.group_created_by FROM family_group INNER JOIN user_to_group ON family_group.id = user_to_group.group_id WHERE user_to_group.user_id = ?";
      let values = [userId];

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

  createOneGroup(req, res) {
    try {
      const { groupName, userId } = req.body;

      let sql = "INSERT family_group(name, group_created_by) VALUES(?, ?)";
      let values = [groupName, userId];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error, rows, fields) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else {

          const groupId = rows.insertId;

          let sql = "INSERT user_to_group(user_id, group_id) VALUES(?, ?)";
          let values = [userId, groupId];

          conn.execute(sql, values, (error) => {
            if (error) {
              res.status(500).send({ "error": { "message": error } });

            } else {
              res.status(200).json({ "data": { "message": "Family group created." } });
            }
          });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }

  getOneGroup(req, res) {
    try {
      const { groupId } = req.params;

      let sql = "SELECT users.uid, users.email FROM family_group INNER JOIN user_to_group ON family_group.id = user_to_group.group_id INNER JOIN users ON user_to_group.user_id = users.id WHERE family_group.id = ?";
      let values = [groupId];

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

  updateGroup(req, res) {
    try {
      const { userId, action } = req.body;
      const { groupId } = req.params;

      let sql = "SELECT count(*) AS row_count FROM family_group WHERE id = ? AND group_created_by = ?";
      let values = [groupId, userId];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error, rows) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else if (rows[0].row_count == 0) {
          res.status(403).send({ "error": { "message": "You can't update group." } });

        } else {
          if (req.body.isInGroup && action == "Add") {
            res.status(422).send({ "error": { "message": "User already in group." } });

          } else if (!req.body.isInGroup && action == "Remove") {
            res.status(404).send({ "error": { "message": "User not find in group." } });

          } else {

            let sql = "";
            if (action == "Add") {
              sql = "INSERT INTO user_to_group(user_id, group_id) VALUES(?, ?)";

            } else if (action == "Remove") {
              sql = "DELETE FROM user_to_group WHERE user_id = ? AND group_id = ?";

            }
            let values = [req.body.userId1, groupId];

            conn.execute(sql, values, (error) => {
              if (error) {
                res.status(500).send({ "error": { "message": error } });

              } else {
                res.status(200).send({ "data": { "message": "Operation done." } });
              }
            });
          }
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }

  deleteGroup(req, res) {
    try {
      const { userId } = req.body;
      const { groupId } = req.params;

      let sql = "SELECT count(*) AS row_count FROM family_group WHERE id = ? AND group_created_by = ?";
      let values = [groupId, userId];

      const conn = mysql.createConnection(connection);

      conn.execute(sql, values, (error, rows) => {
        if (error) {
          res.status(500).send({ "error": { "message": error } });

        } else if (rows[0].row_count == 0) {
          res.status(404).send({ "error": { "message": "Group not found." } });

        } else {
          let sql = "DELETE FROM family_group WHERE group_created_by = ? AND id = ?";
          let values = [userId, groupId];

          conn.execute(sql, values, (error) => {
            if (error) {
              res.status(500).send({ "error": { "message": error } });

            } else {
              res.status(200).send({ "data": { "message": "Group deleted." } });
            }
          });
        }
        conn.end();
      });

    } catch (error) {
      res.status(500).send({ "error": { "message": error } });
      return;
    }
  }
}

export default new FamilyGroupController();
