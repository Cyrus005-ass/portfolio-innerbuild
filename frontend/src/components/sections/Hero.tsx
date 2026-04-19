import { uploadUrl } from '../../lib/api';
import type { Profile } from '../../lib/types';

export function Hero({ profile }: { profile: Profile }) {
  const heroImage = profile.avatar ? uploadUrl(profile.avatar) : '';

  return (
    <section id="hero" className="hero-section">
      <div className="hero-bg" style={{ backgroundImage: heroImage ? `linear-gradient(to bottom, rgba(6, 9, 14, .48), rgba(6, 9, 14, .68)), url(${heroImage})` : 'linear-gradient(to bottom, rgba(6, 9, 14, .48), rgba(6, 9, 14, .68))' }} aria-hidden="true" />
      <div className="container hero-shell">
        <div className="hero-copy">
          <p className="hero-kicker">Dev back-end</p>
          <h1>{profile.nom || 'Portfolio'}</h1>
          <p className="hero-role-text">{profile.titre || 'Développeur web full-stack'}</p>
        </div>
        <div className="hero-located">
          <span>Located in Benin</span>
          <span className="hero-dot" />
        </div>
      </div>
    </section>
  );
}
