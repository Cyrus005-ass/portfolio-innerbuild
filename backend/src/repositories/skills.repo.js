const db = require('../config/db');

async function listSkills() {
  const [rows] = await db.execute('SELECT * FROM skills ORDER BY categorie, ordre ASC');
  return rows;
}

async function getSkillById(id) {
  const [rows] = await db.execute('SELECT * FROM skills WHERE id=? LIMIT 1', [id]);
  return rows[0] || null;
}

async function createSkill(payload) {
  const sql = 'INSERT INTO skills (nom, categorie, niveau, icone, ordre, actif) VALUES (?, ?, ?, ?, ?, ?)';
  const [result] = await db.execute(sql, [
    payload.nom,
    payload.categorie,
    payload.niveau,
    payload.icone,
    payload.ordre,
    payload.actif
  ]);
  return getSkillById(result.insertId);
}

async function updateSkill(id, payload) {
  const sql = 'UPDATE skills SET nom=?, categorie=?, niveau=?, icone=?, ordre=?, actif=? WHERE id=?';
  await db.execute(sql, [
    payload.nom,
    payload.categorie,
    payload.niveau,
    payload.icone,
    payload.ordre,
    payload.actif,
    id
  ]);
  return getSkillById(id);
}

async function deleteSkill(id) {
  await db.execute('DELETE FROM skills WHERE id=?', [id]);
}

module.exports = {
  listSkills,
  getSkillById,
  createSkill,
  updateSkill,
  deleteSkill
};
