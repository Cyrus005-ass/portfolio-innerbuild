const profileService = require('../services/profile.service');

async function getProfile(_req, res, next) {
  try {
    const profile = await profileService.getProfile();
    res.json(profile || {});
  } catch (err) {
    next(err);
  }
}

async function updateProfile(req, res, next) {
  try {
    const profile = await profileService.updateProfile(req.body || {});
    res.json(profile);
  } catch (err) {
    next(err);
  }
}

module.exports = {
  getProfile,
  updateProfile
};
