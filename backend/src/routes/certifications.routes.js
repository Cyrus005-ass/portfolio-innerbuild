const express = require('express');
const certController = require('../controllers/certifications.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.get('/', certController.listCertifications);
router.post('/admin/certifications', authJwt, certController.createCertification);
router.put('/admin/certifications/:id', authJwt, certController.updateCertification);
router.delete('/admin/certifications/:id', authJwt, certController.deleteCertification);

module.exports = router;
