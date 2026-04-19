const express = require('express');
const projectsController = require('../controllers/projects.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.get('/', projectsController.listProjects);
router.get('/:id', projectsController.getProject);
router.post('/', authJwt, projectsController.createProject);
router.put('/:id', authJwt, projectsController.updateProject);
router.delete('/:id', authJwt, projectsController.deleteProject);

module.exports = router;
