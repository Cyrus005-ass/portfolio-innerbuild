const profileRepo = require('../repositories/profile.repo');

async function getProfile() {
  return profileRepo.getProfile();
}

async function updateProfile(data) {
  const payload = {
    nom: (data.nom || '').trim(),
    titre: (data.titre || '').trim(),
    site_theme: (data.site_theme || 'midnight').trim(),
    bio: (data.bio || '').trim(),
    email_contact: (data.email_contact || '').trim(),
    telephone: (data.telephone || '').trim(),
    github: (data.github || '').trim(),
    linkedin: (data.linkedin || '').trim(),
    instagram: (data.instagram || '').trim(),
    avatar: (data.avatar || '').trim(),
    localisation: (data.localisation || 'Bénin').trim(),
    cv_url: (data.cv_url || '').trim()
  };

  const allowedThemes = ['midnight', 'ocean', 'sunset', 'forest'];
  if (!allowedThemes.includes(payload.site_theme)) {
    payload.site_theme = 'midnight';
  }

  return profileRepo.updateProfile(payload);
}

module.exports = {
  getProfile,
  updateProfile
};
