'use client';

import { useMemo, useState, type FormEvent } from 'react';

const skills = [
  { category: 'Backend', items: ['PHP', 'Node.js', 'Express', 'REST API'] },
  { category: 'Frontend', items: ['HTML', 'CSS', 'JavaScript', 'React', 'Next.js'] },
  { category: 'Base de données', items: ['MySQL', 'PostgreSQL', 'SQL'] },
  { category: 'Outils', items: ['Git', 'GitHub', 'WAMP', 'VS Code'] },
];

const projects = [
  {
    title: 'Portfolio personnel',
    description: 'Une vitrine moderne pour présenter mes compétences, projets et certifications.',
    tags: ['Design', 'Responsive', 'SEO'],
  },
  {
    title: 'Tableau de bord admin',
    description: 'Interface d’administration pour gérer le contenu d’un portfolio dynamique.',
    tags: ['CRUD', 'Auth', 'Dashboard'],
  },
  {
    title: 'API portfolio',
    description: 'Architecture backend prête pour connecter les contenus du site.',
    tags: ['API', 'Express', 'Database'],
  },
];

const certifications = [
  'Développement Web',
  'Intégration UI',
  'Bases de données relationnelles',
];

export default function HomePage() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [sent, setSent] = useState(false);

  const navLinks = useMemo(
    () => [
      ['Accueil', '#hero'],
      ['À propos', '#about'],
      ['Compétences', '#skills'],
      ['Projets', '#projects'],
      ['Certifications', '#certifications'],
      ['Contact', '#contact'],
    ],
    [],
  );

  const onSubmit = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    setSent(true);
    event.currentTarget.reset();
    window.setTimeout(() => setSent(false), 2500);
  };

  return (
    <main className="portfolio">
      <header className="site-header">
        <div className="container header-shell">
          <a className="brand" href="#hero">
            <span className="brand-mark">CY</span>
            <span className="brand-text">C-Y Ass</span>
          </a>

          <button className="nav-toggle" type="button" onClick={() => setMenuOpen((value) => !value)} aria-expanded={menuOpen} aria-controls="site-nav">
            Menu
          </button>

          <nav id="site-nav" className={`site-nav ${menuOpen ? 'is-open' : ''}`}>
            {navLinks.map(([label, href]) => (
              <a key={href} href={href} onClick={() => setMenuOpen(false)}>
                {label}
              </a>
            ))}
          </nav>
        </div>
      </header>

      <section id="hero" className="hero-section">
        <div className="container hero-shell">
          <div className="hero-copy">
            <p className="hero-kicker">Développeur web</p>
            <h1>Je construis des interfaces claires et des expériences fluides.</h1>
            <p className="hero-role-text">
              Portfolio front-end statique réalisé uniquement en HTML, CSS et JavaScript via React.
            </p>
            <div className="hero-actions">
              <a className="btn btn-primary" href="#projects">Voir les projets</a>
              <a className="btn btn-secondary" href="#contact">Me contacter</a>
            </div>
          </div>

          <aside className="hero-located">
            <span>Disponible pour de nouveaux projets</span>
            <span className="hero-dot" />
          </aside>
        </div>
      </section>

      <section id="about" className="about-section">
        <div className="container about-shell">
          <div className="about-photo" aria-hidden="true">
            <div className="about-photo-inner">
              <span>Portfolio</span>
              <strong>Front uniquement</strong>
            </div>
          </div>

          <div className="about-card">
            <h2 className="section-title section-title-tight">À propos</h2>
            <p className="about-text">
              Je crée des interfaces propres, rapides et faciles à utiliser. Cette version du site est volontairement
              indépendante du backend pour valider d’abord l’expérience visuelle, la structure et le comportement côté client.
            </p>
            <div className="about-actions">
              <a className="btn btn-secondary" href="#skills">Voir les compétences</a>
              <a className="btn btn-primary" href="#contact">Démarrer un projet</a>
            </div>
          </div>
        </div>
      </section>

      <section id="skills" className="skills-section">
        <div className="container">
          <h2 className="section-title section-title-tight">Compétences</h2>
          <div className="skills-layout">
            {skills.map((group) => (
              <article key={group.category} className="skill-category">
                <h3 className="skill-category-title">{group.category}</h3>
                <ul className="skill-list">
                  {group.items.map((item) => (
                    <li key={item} className="skill-item">
                      <span className="skill-pill">{item}</span>
                    </li>
                  ))}
                </ul>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section id="projects" className="projects-section">
        <div className="container">
          <h2 className="section-title section-title-tight">Projets</h2>
          <div className="projects-grid">
            {projects.map((project) => (
              <article key={project.title} className="project-card">
                <div className="project-image project-fallback">{project.title.slice(0, 2).toUpperCase()}</div>
                <div className="project-details">
                  <h3>{project.title}</h3>
                  <p>{project.description}</p>
                  <div className="project-stack">
                    {project.tags.map((tag) => (
                      <span key={tag}>{tag}</span>
                    ))}
                  </div>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section id="certifications" className="certifications-section">
        <div className="container">
          <h2 className="section-title section-title-tight">Certifications</h2>
          <div className="cert-grid">
            {certifications.map((cert) => (
              <article key={cert} className="cert-card">
                <div className="cert-media cert-fallback">CERT</div>
                <div className="cert-body">
                  <h3>{cert}</h3>
                  <p>Validation de compétences sur les fondamentaux du développement web.</p>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section id="contact" className="contact-section">
        <div className="container contact-shell">
          <div className="contact-head">
            <h2 className="section-title section-title-tight">Contact</h2>
            <p>Une idée, une mission ou un projet à lancer. Le formulaire fonctionne côté client pour la démonstration.</p>
            <a href="mailto:contact@example.com">contact@example.com</a>
          </div>

          <form className="contact-form" onSubmit={onSubmit}>
            <div className="contact-grid-2">
              <input required name="nom" placeholder="Votre nom" />
              <input required name="email" type="email" placeholder="Votre email" />
            </div>
            <input required name="sujet" placeholder="Sujet" />
            <textarea required name="contenu" rows={6} placeholder="Votre message" />
            <button type="submit" className="btn btn-primary">Envoyer le message</button>
            {sent ? <p className="form-success">Message prêt à être envoyé. Le backend sera branché ensuite.</p> : null}
          </form>
        </div>
      </section>
    </main>
  );
}
