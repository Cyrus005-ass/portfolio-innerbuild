const db = require('../config/db');

async function findAdminByEmail(email) {
  const [rows] = await db.execute('SELECT * FROM admins WHERE email = ? LIMIT 1', [email]);
  return rows[0] || null;
}

module.exports = {
  findAdminByEmail
};
