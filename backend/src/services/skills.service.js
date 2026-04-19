const skillsRepo = require('../repositories/skills.repo');

function groupByCategory(rows) {
  return rows.reduce((acc, item) => {
    const key = item.categorie || 'Autres';
    if (!acc[key]) acc[key] = [];
    acc[key].push(item);
    return acc;
  }, {});
}

async function listSkills({ grouped = false } = {}) {
  const rows = await skillsRepo.listSkills();
  return grouped ? groupByCategory(rows) : rows;
}

async function createSkill(data) {
  const payload = {
    nom: (data.nom || '').trim(),
    categorie: (data.categorie || 'Frontend').trim(),
    niveau: Number(data.niveau || 80),
    icone: (data.icone || '').trim(),
    ordre: Number(data.ordre || 0),
    actif: Number(data.actif ?? 1)
  };

  if (!payload.nom) {
    const err = new Error('Le nom de la compétence est requis');
    err.status = 400;
    throw err;
  }

  return skillsRepo.createSkill(payload);
}

async function updateSkill(id, data) {
  const payload = {
    nom: (data.nom || '').trim(),
    categorie: (data.categorie || 'Frontend').trim(),
    niveau: Number(data.niveau || 80),
    icone: (data.icone || '').trim(),
    ordre: Number(data.ordre || 0),
    actif: Number(data.actif ?? 1)
  };
  return skillsRepo.updateSkill(id, payload);
}

async function deleteSkill(id) {
  return skillsRepo.deleteSkill(id);
}

module.exports = {
  listSkills,
  createSkill,
  updateSkill,
  deleteSkill
};
