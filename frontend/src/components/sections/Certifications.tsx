import { uploadUrl } from '@/lib/api';
import type { Certification } from '@/lib/types';

export function Certifications({ certifications }: { certifications: Certification[] }) {
  return (
    <section id="certifications" className="certifications-section">
      <div className="container">
        <h2 className="section-title section-title-tight">Certifications</h2>
        {certifications.length === 0 ? (
          <p className="empty-state">Aucune certification pour le moment.</p>
        ) : (
          <div className="cert-grid">
            {certifications.map((cert) => (
              <article key={cert.id} className="cert-card">
                <div className="cert-media">
                  {cert.photo ? <img src={uploadUrl(cert.photo)} alt={cert.nom} /> : <div className="cert-fallback">CERT</div>}
                </div>
                <div className="cert-body">
                  <h3>{cert.nom}</h3>
                  <p>{cert.organisme}</p>
                  <div className="project-stack cert-meta">
                    {cert.date_obtention ? <span>{new Date(cert.date_obtention).toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' })}</span> : null}
                  </div>
                  {cert.lien_verification ? (
                    <a className="btn btn-secondary" href={cert.lien_verification} target="_blank" rel="noreferrer">
                      Vérifier
                    </a>
                  ) : null}
                </div>
              </article>
            ))}
          </div>
        )}
      </div>
    </section>
  );
}
