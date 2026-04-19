const skillsService = require('../services/skills.service');

async function listSkills(req, res, next) {
  try {
    const grouped = String(req.query.grouped || 'false') === 'true';
    const data = await skillsService.listSkills({ grouped });
    res.json(data);
  } catch (err) {
    next(err);
  }
}

async function createSkill(req, res, next) {
  try {
    const item = await skillsService.createSkill(req.body || {});
    res.status(201).json(item);
  } catch (err) {
    next(err);
  }
}

async function updateSkill(req, res, next) {
  try {
    const item = await skillsService.updateSkill(Number(req.params.id), req.body || {});
    res.json(item);
  } catch (err) {
    next(err);
  }
}

async function deleteSkill(req, res, next) {
  try {
    await skillsService.deleteSkill(Number(req.params.id));
    res.status(204).send();
  } catch (err) {
    next(err);
  }
}

module.exports = {
  listSkills,
  createSkill,
  updateSkill,
  deleteSkill
};
