const messagesService = require('../services/messages.service');

async function listMessages(_req, res, next) {
  try {
    const rows = await messagesService.listMessages();
    res.json(rows);
  } catch (err) {
    next(err);
  }
}

async function createContactMessage(req, res, next) {
  try {
    await messagesService.createContactMessage(req.body || {});
    res.status(201).json({ success: true });
  } catch (err) {
    next(err);
  }
}

module.exports = {
  listMessages,
  createContactMessage
};
