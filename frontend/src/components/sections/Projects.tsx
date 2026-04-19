import { uploadUrl } from '../../lib/api';
import type { Project } from '../../lib/types';

export function Projects({ projects }: { projects: Project[] }) {
  return (
    <section id="projects" className="projects-section">
      <div className="container">
        <h2 className="section-title section-title-tight">Projets récents</h2>
        <div className="projects-grid">
          {projects.map((p) => (
            <article key={p.id} className="project-card">
              <div className="project-image">
                {p.image ? <img src={uploadUrl(p.image)} alt={p.titre} /> : <div className="project-fallback">Projet</div>}
              </div>
              <div className="project-details">
                <h3>{p.titre}</h3>
                <p>{p.description}</p>
                {p.technologies ? (
                  <div className="project-stack">
                    {p.technologies.split(',').map((item) => (
                      <span key={item.trim()}>{item.trim()}</span>
                    ))}
                  </div>
                ) : null}
                <div className="project-links">
                  {p.lien_live ? (
                    <a className="btn btn-secondary" href={p.lien_live} target="_blank" rel="noreferrer">
                      Live Demo
                    </a>
                  ) : null}
                  {p.lien_github ? (
                    <a className="btn btn-secondary" href={p.lien_github} target="_blank" rel="noreferrer">
                      Source Code
                    </a>
                  ) : null}
                </div>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
