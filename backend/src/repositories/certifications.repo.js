const db = require('../config/db');

async function listCertifications() {
  const [rows] = await db.execute('SELECT * FROM certifications ORDER BY ordre ASC, date_obtention DESC');
  return rows;
}

async function getCertificationById(id) {
  const [rows] = await db.execute('SELECT * FROM certifications WHERE id=? LIMIT 1', [id]);
  return rows[0] || null;
}

async function createCertification(payload) {
  const sql = `
    INSERT INTO certifications (nom, organisme, date_obtention, lien_verification, photo, ordre, actif)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  `;
  const [result] = await db.execute(sql, [
    payload.nom,
    payload.organisme,
    payload.date_obtention,
    payload.lien_verification,
    payload.photo,
    payload.ordre,
    payload.actif
  ]);
  return getCertificationById(result.insertId);
}

async function updateCertification(id, payload) {
  const sql = `
    UPDATE certifications
    SET nom=?, organisme=?, date_obtention=?, lien_verification=?, photo=?, ordre=?, actif=?
    WHERE id=?
  `;
  await db.execute(sql, [
    payload.nom,
    payload.organisme,
    payload.date_obtention,
    payload.lien_verification,
    payload.photo,
    payload.ordre,
    payload.actif,
    id
  ]);
  return getCertificationById(id);
}

async function deleteCertification(id) {
  await db.execute('DELETE FROM certifications WHERE id=?', [id]);
}

module.exports = {
  listCertifications,
  getCertificationById,
  createCertification,
  updateCertification,
  deleteCertification
};
