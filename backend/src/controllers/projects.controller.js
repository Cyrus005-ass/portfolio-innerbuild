const projectsService = require('../services/projects.service');

async function listProjects(_req, res, next) {
  try {
    const data = await projectsService.listProjects();
    res.json(data);
  } catch (err) {
    next(err);
  }
}

async function createProject(req, res, next) {
  try {
    const item = await projectsService.createProject(req.body || {});
    res.status(201).json(item);
  } catch (err) {
    next(err);
  }
}

async function updateProject(req, res, next) {
  try {
    const item = await projectsService.updateProject(Number(req.params.id), req.body || {});
    res.json(item);
  } catch (err) {
    next(err);
  }
}

async function deleteProject(req, res, next) {
  try {
    await projectsService.deleteProject(Number(req.params.id));
    res.status(204).send();
  } catch (err) {
    next(err);
  }
}

module.exports = {
  listProjects,
  createProject,
  updateProject,
  deleteProject
};
