const db = require('../config/db');

async function listMessages() {
  const [rows] = await db.execute('SELECT * FROM messages ORDER BY date_envoi DESC, id DESC');
  return rows;
}

async function createMessage(payload) {
  const sql = 'INSERT INTO messages (nom, email, sujet, contenu, date_envoi) VALUES (?, ?, ?, ?, NOW())';
  await db.execute(sql, [payload.nom, payload.email, payload.sujet, payload.contenu]);
}

module.exports = {
  listMessages,
  createMessage
};
