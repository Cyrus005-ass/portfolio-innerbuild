const express = require('express');
const messagesController = require('../controllers/messages.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.post('/', messagesController.createContactMessage);
router.get('/', authJwt, messagesController.listMessages);

module.exports = router;
