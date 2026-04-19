'use client';

import { useState, type FormEvent } from 'react';
import { apiPost } from '../../lib/api';
import type { Profile } from '../../lib/types';

export function Contact({ profile }: { profile: Profile }) {
  const [form, setForm] = useState({ nom: '', email: '', sujet: '', contenu: '' });
  const [status, setStatus] = useState<'idle' | 'loading' | 'success' | 'error'>('idle');
  const [message, setMessage] = useState('');

  const onSubmit = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setStatus('loading');
    setMessage('');

    try {
      await apiPost('/messages', form);
      setStatus('success');
      setForm({ nom: '', email: '', sujet: '', contenu: '' });
    } catch (err) {
      setStatus('error');
      setMessage(err instanceof Error ? err.message : 'Une erreur est survenue.');
    }
  };

  return (
    <section id="contact" className="contact-section">
      <div className="container contact-shell">
        <div className="contact-head">
          <h2 className="section-title section-title-tight">Contact</h2>
          <p>Un projet, une idée ou une mission. Je réponds rapidement.</p>
          {profile.email_contact ? <a href={`mailto:${profile.email_contact}`}>{profile.email_contact}</a> : null}
        </div>

        <form className="contact-form" onSubmit={onSubmit}>
          <div className="contact-grid-2">
            <input required placeholder="Votre nom" value={form.nom} onChange={(e) => setForm({ ...form, nom: e.target.value })} />
            <input required type="email" placeholder="Votre email" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} />
          </div>
          <input required placeholder="Sujet" value={form.sujet} onChange={(e) => setForm({ ...form, sujet: e.target.value })} />
          <textarea required rows={6} placeholder="Votre message" value={form.contenu} onChange={(e) => setForm({ ...form, contenu: e.target.value })} />
          <button type="submit" className="btn btn-primary" disabled={status === 'loading'}>
            {status === 'loading' ? 'Envoi...' : 'Envoyer le message'}
          </button>
          {status === 'success' ? <p className="form-success">Message envoyé avec succès.</p> : null}
          {status === 'error' ? <p className="form-error">{message}</p> : null}
        </form>
      </div>
    </section>
  );
}
