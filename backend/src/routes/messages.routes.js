const express = require('express');
const messagesController = require('../controllers/messages.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.post('/contact', messagesController.createContactMessage);
router.get('/admin/messages', authJwt, messagesController.listMessages);

module.exports = router;
