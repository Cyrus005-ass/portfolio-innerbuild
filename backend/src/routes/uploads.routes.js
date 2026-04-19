const express = require('express');
const path = require('path');
const { authJwt } = require('../middlewares/authJwt');
const uploadsController = require('../controllers/uploads.controller');
const { imageUpload, documentUpload, uploadDir } = require('../utils/upload');

const router = express.Router();

router.post('/image', authJwt, imageUpload.single('file'), uploadsController.uploadImage);
router.post('/document', authJwt, documentUpload.single('file'), uploadsController.uploadDocument);

router.get('/:filename', (req, res) => {
  const resolvedPath = path.resolve(uploadDir, req.params.filename);
  const rootPath = path.resolve(uploadDir) + path.sep;

  if (!resolvedPath.startsWith(rootPath)) {
    return res.status(400).json({ error: 'Nom de fichier invalide' });
  }

  res.sendFile(resolvedPath, (err) => {
    if (err) {
      res.status(404).json({ error: 'Fichier non trouvé' });
    }
  });
});

module.exports = router;
