import { uploadUrl } from '@/lib/api';
import type { Profile } from '@/lib/types';

export function About({ profile }: { profile: Profile }) {
  const bio = profile.bio || 'Passionné par la création d\'expériences web immersives et performantes.';
  const aboutImage = profile.avatar ? uploadUrl(profile.avatar) : '';

  return (
    <section id="about" className="about-section">
      <div className="container about-shell">
        <div className="about-photo" style={{ backgroundImage: aboutImage ? `linear-gradient(to bottom, rgba(7, 10, 16, .08), rgba(7, 10, 16, .6)), url(${aboutImage})` : 'linear-gradient(to bottom, rgba(7, 10, 16, .18), rgba(7, 10, 16, .72))' }} aria-hidden="true" />
        <div className="about-card">
          <h2 className="section-title section-title-tight">À propos</h2>
          <p className="about-text">{bio}</p>
          <div className="about-actions">
            {profile.cv_url ? (
              <a className="btn btn-secondary" href={uploadUrl(profile.cv_url)} target="_blank" rel="noreferrer">
                Télécharger le CV
              </a>
            ) : null}
            <a className="btn btn-primary" href="#contact">
              Me contacter
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}
