const certRepo = require('../repositories/certifications.repo');

async function listCertifications() {
  return certRepo.listCertifications();
}

async function createCertification(data) {
  const payload = {
    nom: (data.nom || '').trim(),
    organisme: (data.organisme || '').trim(),
    date_obtention: data.date_obtention || null,
    lien_verification: (data.lien_verification || '').trim(),
    photo: (data.photo || '').trim(),
    ordre: Number(data.ordre || 0),
    actif: Number(data.actif ?? 1)
  };

  if (!payload.nom || !payload.organisme) {
    const err = new Error('Le nom et l\'organisme sont requis');
    err.status = 400;
    throw err;
  }

  return certRepo.createCertification(payload);
}

async function updateCertification(id, data) {
  const payload = {
    nom: (data.nom || '').trim(),
    organisme: (data.organisme || '').trim(),
    date_obtention: data.date_obtention || null,
    lien_verification: (data.lien_verification || '').trim(),
    photo: (data.photo || '').trim(),
    ordre: Number(data.ordre || 0),
    actif: Number(data.actif ?? 1)
  };
  return certRepo.updateCertification(id, payload);
}

async function deleteCertification(id) {
  return certRepo.deleteCertification(id);
}

module.exports = {
  listCertifications,
  createCertification,
  updateCertification,
  deleteCertification
};
