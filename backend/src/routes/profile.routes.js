const express = require('express');
const profileController = require('../controllers/profile.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.get('/', profileController.getProfile);
router.put('/admin/profile', authJwt, profileController.updateProfile);

module.exports = router;
