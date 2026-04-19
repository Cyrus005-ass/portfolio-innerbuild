function uploadImage(req, res) {
  if (!req.file) {
    return res.status(400).json({ error: 'Fichier image requis' });
  }
  return res.status(201).json({ filename: req.file.filename });
}

function uploadDocument(req, res) {
  if (!req.file) {
    return res.status(400).json({ error: 'Fichier document requis' });
  }
  return res.status(201).json({ filename: req.file.filename });
}

module.exports = {
  uploadImage,
  uploadDocument
};
