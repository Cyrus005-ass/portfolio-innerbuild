const db = require('../config/db');

async function getProfile() {
  const [rows] = await db.execute('SELECT * FROM profil WHERE id = 1 LIMIT 1');
  return rows[0] || null;
}

async function updateProfile(payload) {
  const sql = `
    UPDATE profil
    SET nom=?, titre=?, site_theme=?, bio=?, email_contact=?, telephone=?, github=?, linkedin=?, instagram=?, avatar=?, localisation=?, cv_url=?
    WHERE id=1
  `;
  const params = [
    payload.nom,
    payload.titre,
    payload.site_theme,
    payload.bio,
    payload.email_contact,
    payload.telephone,
    payload.github,
    payload.linkedin,
    payload.instagram,
    payload.avatar,
    payload.localisation,
    payload.cv_url
  ];
  await db.execute(sql, params);
  return getProfile();
}

module.exports = {
  getProfile,
  updateProfile
};
