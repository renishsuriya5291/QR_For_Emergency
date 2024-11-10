import createError from "http-errors";
import express from "express";
import cookieParser from "cookie-parser";
import logger from "morgan";
import "dotenv/config";
import cors from "cors";

import indexRouter from "./routes/index.js";
import apiV0 from "./routes/api/v0/v0.js";

export const app = express();

// view engine setup
app.set("views", "views");
app.set("view engine", "jade");

app.use(cors());
app.use(logger("dev"));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static("public"));

app.use("/", indexRouter);
app.use("/api/v0", apiV0);

app.get("/test-db-connection", async (req, res) => {
  const connection = await mysql.createConnection({
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE
  });

  try {
    // Test the connection
    await connection.ping();
    res.status(200).json({ message: "Database connection successful!" });
  } catch (error) {
    console.error("Database connection failed:", error);
    res.status(500).json({ message: "Database connection failed", error: error.message });
  } finally {
    // Close the connection
    await connection.end();
  }
});

// catch 404 and forward to error handler
app.use(function (req, res, next) {
  next(createError(404));
});

// error handler
app.use(function (err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get("env") === "development" ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render("error");
});




// Stat the server.
const PORT = process.env.PORT || 65535;
app.listen(PORT, "0.0.0.0", () => {
  console.log(`App listening on port ${PORT}.`)
});
