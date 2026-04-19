const bcrypt = require('bcryptjs');
const adminRepo = require('../repositories/admin.repo');
const { signAccessToken } = require('../utils/tokens');

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

  return {
    access_token: token,
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
