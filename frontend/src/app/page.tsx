'use client';

import { useState, type FormEvent } from 'react';

const profile = {
  name: 'Cyrus-y ASSOGBA',
  title: 'Développeur Web Full-Stack & UI/UX Designer',
  location: 'Located in Bénin',
  bio:
    "Passionné par la création d'expériences web immersives et performantes. Mon approche marie un code structuré, une architecture backend robuste et un design interactif impactant orienté utilisateur.",
  email: 'contact@cyrusy.dev',
  linkedin: 'https://linkedin.com/in/cyrusy',
  github: 'https://github.com/cyrusy',
  avatar: '/assets/img/cyr.png',
  heroImage: '/assets/img/ass.png',
  cv: '/uploads/cv_69e4140e903c9.pdf',
};

const highlights = [
  { value: '05+', label: 'années' },
  { value: '12', label: 'livrables' },
  { value: '100%', label: 'sur mesure' },
];

const skills = [
  {
    category: 'Frontend',
    items: [
      { name: 'HTML5 / CSS3', level: 95 },
      { name: 'JavaScript (ES6+)', level: 90 },
      { name: 'GSAP / Motion', level: 85 },
    ],
  },
  {
    category: 'Backend',
    items: [
      { name: 'PHP 8', level: 90 },
      { name: 'MySQL', level: 85 },
    ],
  },
  {
    category: 'Design',
    items: [
      { name: 'UI / UX Design', level: 80 },
    ],
  },
];

const projects = [
  {
    title: 'Portfolio Premium',
    description:
      'Portfolio immersif développé avec une approche motion design fluide via GSAP, un espace d’administration PHP sur mesure et un code ultra optimisé.',
    tags: ['HTML', 'CSS', 'JS', 'GSAP', 'PHP', 'MySQL'],
    image: '/uploads/317c70198936b0f591d56c887ca87f70e507987b_69e3b7baecf52.jpg',
    year: '2026',
  },
  {
    title: 'E-commerce Architect',
    description:
      'Plateforme de vente en ligne complète avec gestion de paniers dynamiques, interface d’administration produit et checkout sécurisé.',
    tags: ['PHP', 'MySQL', 'Stripe API'],
    image: '/uploads/1a90d167b1dea4db725289f68689b5161d6de08a_69e3b7a5f14a1.jpg',
    year: '2025',
  },
];

const certifications = [
  {
    title: 'Certification Web 01',
    issuer: 'Développement web',
    date: '2026',
    image: '/uploads/8e4124897bfff812e9a2e424436bf723398c69da_69e391f4cb0b1.png',
  },
  {
    title: 'Certification Web 02',
    issuer: 'Intégration UI / UX',
    date: '2026',
    image: '/uploads/8e4124897bfff812e9a2e424436bf723398c69da_69e38f71b15c7.png',
  },
  {
    title: 'Certification Web 03',
    issuer: 'Bases de données',
    date: '2026',
    image: '/uploads/073c7576b57dfafa7556115c4364dddfb6c7f243_69e38eeb6125f.png',
  },
  {
    title: 'Certification Web 04',
    issuer: 'Déploiement & production',
    date: '2026',
    image: '/uploads/073c7576b57dfafa7556115c4364dddfb6c7f243_69e38d8726a69.png',
  },
];

export default function HomePage() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [sent, setSent] = useState(false);

  const navLinks = [
    ['Accueil', '#hero'],
    ['À propos', '#about'],
    ['Compétences', '#skills'],
    ['Projets', '#projects'],
    ['Certifications', '#certifications'],
    ['Contact', '#contact'],
  ];

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
        <div
          className="hero-bg"
          aria-hidden="true"
          style={{
            backgroundImage: `linear-gradient(to bottom, rgba(6, 9, 14, 0.42), rgba(6, 9, 14, 0.82)), url(${profile.heroImage})`,
          }}
        />
        <div className="container hero-shell">
          <div className="hero-copy">
            <p className="hero-kicker">Portfolio premium</p>
            <h1>{profile.name}</h1>
            <p className="hero-role-text">{profile.title}</p>
            <div className="hero-actions">
              <a className="btn btn-primary" href="#projects">Voir les projets</a>
              <a className="btn btn-secondary" href="#contact">Me contacter</a>
            </div>
            <div className="hero-highlights" aria-label="Points forts">
              {highlights.map((item) => (
                <div key={item.label} className="hero-highlight">
                  <strong>{item.value}</strong>
                  <span>{item.label}</span>
                </div>
              ))}
            </div>
          </div>

          <aside className="hero-sidecard">
            <div className="hero-sidecard-media">
              <img src={profile.avatar} alt={`Portrait de ${profile.name}`} loading="eager" />
            </div>
            <div className="hero-sidecard-body">
              <p className="hero-sidecard-label">Basé à</p>
              <h2>{profile.location}</h2>
              <p>Interface statique, direction artistique sombre et contenu réel du portfolio intégrés localement.</p>
              <div className="hero-sidecard-links">
                <a href={profile.github} target="_blank" rel="noreferrer">GitHub</a>
                <a href={profile.linkedin} target="_blank" rel="noreferrer">LinkedIn</a>
              </div>
            </div>
          </aside>
        </div>
      </section>

      <section id="about" className="about-section">
        <div className="container about-shell">
          <div
            className="about-photo"
            aria-hidden="true"
            style={{
              backgroundImage: `linear-gradient(to bottom, rgba(7, 10, 16, 0.08), rgba(7, 10, 16, 0.6)), url(${profile.avatar})`,
            }}
          >
            <div className="about-photo-badge">Available for premium freelance work</div>
            <div className="about-photo-inner">
              <span>Profil</span>
              <strong>{profile.name}</strong>
            </div>
          </div>

          <div className="about-card">
            <h2 className="section-title section-title-tight">À propos</h2>
            <p className="about-text">{profile.bio}</p>
            <div className="about-actions">
              <a className="btn btn-secondary" href="#skills">Voir les compétences</a>
              <a className="btn btn-primary" href={profile.cv} download>Télécharger le CV</a>
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
                    <li key={item.name} className="skill-item">
                      <span className="skill-pill">
                        {item.name}
                        <small>{item.level}%</small>
                      </span>
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
                <div className="project-image">
                  <img src={project.image} alt={`Aperçu de ${project.title}`} loading="lazy" />
                </div>
                <div className="project-details">
                  <div className="project-header-row">
                    <h3>{project.title}</h3>
                    <span className="project-year">{project.year}</span>
                  </div>
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
              <article key={cert.title} className="cert-card">
                <div className="cert-media">
                  <img src={cert.image} alt={cert.title} loading="lazy" />
                </div>
                <div className="cert-body">
                  <h3>{cert.title}</h3>
                  <p>{cert.issuer}</p>
                  <div className="project-stack cert-meta">
                    <span>{cert.date}</span>
                  </div>
                  <a className="cert-link" href={cert.image} target="_blank" rel="noreferrer">
                    Ouvrir
                  </a>
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
            <a href={`mailto:${profile.email}`}>{profile.email}</a>
            <div className="contact-links-inline">
              <a href={profile.github} target="_blank" rel="noreferrer">GitHub</a>
              <a href={profile.linkedin} target="_blank" rel="noreferrer">LinkedIn</a>
            </div>
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
