const certService = require('../services/certifications.service');

async function listCertifications(_req, res, next) {
  try {
    const rows = await certService.listCertifications();
    res.json(rows);
  } catch (err) {
    next(err);
  }
}

async function createCertification(req, res, next) {
  try {
    const item = await certService.createCertification(req.body || {});
    res.status(201).json(item);
  } catch (err) {
    next(err);
  }
}

async function updateCertification(req, res, next) {
  try {
    const item = await certService.updateCertification(Number(req.params.id), req.body || {});
    res.json(item);
  } catch (err) {
    next(err);
  }
}

async function deleteCertification(req, res, next) {
  try {
    await certService.deleteCertification(Number(req.params.id));
    res.status(204).send();
  } catch (err) {
    next(err);
  }
}

module.exports = {
  listCertifications,
  createCertification,
  updateCertification,
  deleteCertification
};
