const messagesRepo = require('../repositories/messages.repo');

async function listMessages() {
  return messagesRepo.listMessages();
}

async function createContactMessage(data) {
  const payload = {
    nom: (data.nom || '').trim(),
    email: (data.email || '').trim(),
    sujet: (data.sujet || '').trim(),
    contenu: (data.message || data.contenu || '').trim()
  };

  if (!payload.nom || !payload.email || !payload.contenu) {
    const err = new Error('Tous les champs obligatoires doivent être remplis.');
    err.status = 400;
    throw err;
  }

  const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email);
  if (!validEmail) {
    const err = new Error('Adresse email invalide.');
    err.status = 400;
    throw err;
  }

  await messagesRepo.createMessage(payload);
}

module.exports = {
  listMessages,
  createContactMessage
};
