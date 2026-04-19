const authService = require('../services/auth.service');

async function login(req, res, next) {
  try {
    const result = await authService.login({
      email: req.body?.email,
      password: req.body?.password
    });
    res.json(result);
  } catch (err) {
    next(err);
  }
}

module.exports = {
  login
};
