const express = require('express');
const cors = require('cors');
const apiRouter = require('./routes');
const { errorHandler } = require('./middlewares/errorHandler');
const { uploadDir } = require('./utils/upload');

const app = express();

const allowedOrigins = (process.env.FRONTEND_URL || '')
  .split(',')
  .map((v) => v.trim())
  .filter(Boolean);

app.use(cors({
  origin: allowedOrigins.length ? allowedOrigins : '*',
  methods: ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization']
}));

app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));
app.use('/uploads', express.static(uploadDir));

app.get('/health', (_req, res) => {
  res.json({ ok: true, service: 'innerbuild-api' });
});

app.use('/api', apiRouter);

app.use(errorHandler);

module.exports = app;
