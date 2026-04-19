const express = require('express');
const skillsController = require('../controllers/skills.controller');
const { authJwt } = require('../middlewares/authJwt');

const router = express.Router();

router.get('/', skillsController.listSkills);
router.post('/admin/skills', authJwt, skillsController.createSkill);
router.put('/admin/skills/:id', authJwt, skillsController.updateSkill);
router.delete('/admin/skills/:id', authJwt, skillsController.deleteSkill);

module.exports = router;
