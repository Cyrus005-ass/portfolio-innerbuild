const bcrypt = require('bcryptjs');
const adminRepo = require('../repositories/admin.repo');
const db = require('../config/db');
const { signAccessToken, signRefreshToken } = require('../utils/tokens');

async function login({ email, password }) {
  const admin = await adminRepo.findAdminByEmail((email || '').trim());
  if (!admin) {
    const err = new Error('Identifiants invalides');
    err.status = 401;
    throw err;
  }

  const ok = await bcrypt.compare(password || '', admin.mot_de_passe_hash || '');
  if (!ok) {
    const err = new Error('Identifiants invalides');
    err.status = 401;
    throw err;
  }

  const token = signAccessToken({
    sub: admin.id,
    role: admin.role || 'admin',
    email: admin.email
  });
  const refresh_token = signRefreshToken({
    sub: admin.id,
    role: admin.role || 'admin',
    email: admin.email
  });

  await db.execute('UPDATE admins SET last_login = NOW() WHERE id = ?', [admin.id]);

  return {
    access_token: token,
    refresh_token,
    admin: {
      id: admin.id,
      email: admin.email,
      role: admin.role
    }
  };
}

module.exports = {
  login
};
