const express = require('express');
const profileRoutes = require('./profile.routes');
const projectsRoutes = require('./projects.routes');
const skillsRoutes = require('./skills.routes');
const certificationsRoutes = require('./certifications.routes');
const messagesRoutes = require('./messages.routes');
const authRoutes = require('./auth.routes');
const uploadsRoutes = require('./uploads.routes');

const router = express.Router();

router.use('/auth', authRoutes);
router.use('/profile', profileRoutes);
router.use('/projects', projectsRoutes);
router.use('/skills', skillsRoutes);
router.use('/certifications', certificationsRoutes);
router.use('/messages', messagesRoutes);
router.use('/uploads', uploadsRoutes);

module.exports = router;
