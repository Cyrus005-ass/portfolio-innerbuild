const db = require('../config/db');

async function listProjects() {
  const [rows] = await db.execute('SELECT * FROM projets ORDER BY ordre ASC, id DESC');
  return rows;
}

async function getProjectById(id) {
  const [rows] = await db.execute('SELECT * FROM projets WHERE id = ? LIMIT 1', [id]);
  return rows[0] || null;
}

async function createProject(payload) {
  const sql = `
    INSERT INTO projets (titre, description, technologies, image, lien_live, lien_github, ordre, annee, actif)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
  `;
  const params = [
    payload.titre,
    payload.description,
    payload.technologies,
    payload.image,
    payload.lien_live,
    payload.lien_github,
    payload.ordre,
    payload.annee,
    payload.actif
  ];
  const [result] = await db.execute(sql, params);
  return getProjectById(result.insertId);
}

async function updateProject(id, payload) {
  const sql = `
    UPDATE projets
    SET titre=?, description=?, technologies=?, image=?, lien_live=?, lien_github=?, ordre=?, annee=?, actif=?
    WHERE id=?
  `;
  const params = [
    payload.titre,
    payload.description,
    payload.technologies,
    payload.image,
    payload.lien_live,
    payload.lien_github,
    payload.ordre,
    payload.annee,
    payload.actif,
    id
  ];
  await db.execute(sql, params);
  return getProjectById(id);
}

async function deleteProject(id) {
  await db.execute('DELETE FROM projets WHERE id=?', [id]);
}

module.exports = {
  listProjects,
  getProjectById,
  createProject,
  updateProject,
  deleteProject
};
