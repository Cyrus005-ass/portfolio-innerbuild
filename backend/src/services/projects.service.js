const projectsRepo = require('../repositories/projects.repo');

async function listProjects() {
  return projectsRepo.listProjects();
}

async function getProjectById(id) {
  return projectsRepo.getProjectById(id);
}

async function createProject(data) {
  const payload = {
    titre: (data.titre || '').trim(),
    description: (data.description || '').trim(),
    technologies: (data.technologies || '').trim(),
    image: (data.image || '').trim(),
    lien_live: (data.lien_live || '').trim(),
    lien_github: (data.lien_github || '').trim(),
    ordre: Number(data.ordre || 0),
    annee: (data.annee || '').trim(),
    actif: Number(data.actif ?? 1)
  };

  if (!payload.titre) {
    const err = new Error('Le titre est requis');
    err.status = 400;
    throw err;
  }

  return projectsRepo.createProject(payload);
}

async function updateProject(id, data) {
  const payload = {
    titre: (data.titre || '').trim(),
    description: (data.description || '').trim(),
    technologies: (data.technologies || '').trim(),
    image: (data.image || '').trim(),
    lien_live: (data.lien_live || '').trim(),
    lien_github: (data.lien_github || '').trim(),
    ordre: Number(data.ordre || 0),
    annee: (data.annee || '').trim(),
    actif: Number(data.actif ?? 1)
  };
  return projectsRepo.updateProject(id, payload);
}

async function deleteProject(id) {
  return projectsRepo.deleteProject(id);
}

module.exports = {
  listProjects,
  getProjectById,
  createProject,
  updateProject,
  deleteProject
};
