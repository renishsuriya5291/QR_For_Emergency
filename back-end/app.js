import createError from 'http-errors';
import express from 'express';
import cookieParser from 'cookie-parser';
import logger from 'morgan';
import "dotenv/config";

import indexRouter from './routes/index.js';
import apiV0 from './routes/api/v0/v0.js';

export const app = express();

// view engine setup
app.set('views', 'views');
app.set('view engine', 'jade');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static('public'));

app.use('/', indexRouter);
app.use('/api/v0', apiV0);

// catch 404 and forward to error handler
app.use(function (req, res, next) {
  next(createError(404));
});

// error handler
app.use(function (err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

// Stat the server.
const PORT = process.env.PORT || 65535;
app.listen(PORT, () => {
  console.log(`App listening on port ${PORT}.`)
});
