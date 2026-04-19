const express = require('express');
const { authJwt } = require('../middlewares/authJwt');
const uploadsController = require('../controllers/uploads.controller');
const { imageUpload, documentUpload } = require('../utils/upload');

const router = express.Router();

router.post('/admin/upload/image', authJwt, imageUpload.single('file'), uploadsController.uploadImage);
router.post('/admin/upload/document', authJwt, documentUpload.single('file'), uploadsController.uploadDocument);

module.exports = router;
