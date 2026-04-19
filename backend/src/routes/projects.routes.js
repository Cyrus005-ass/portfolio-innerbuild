const express = require('express');
const projectsController = require('../controllers/projects.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.get('/', projectsController.listProjects);
router.post('/admin/projects', authJwt, projectsController.createProject);
router.put('/admin/projects/:id', authJwt, projectsController.updateProject);
router.delete('/admin/projects/:id', authJwt, projectsController.deleteProject);

module.exports = router;
