type Project = {
  id: number;
  titre: string;
  description: string;
};

export function Projects({ projects }: { projects: Project[] }) {
  return (
    <section id="projects">
      <div className="container">
        <h2>Projets</h2>
        <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fit,minmax(260px,1fr))' }}>
          {projects.map((p) => (
            <article key={p.id} style={{ border: '1px solid rgba(255,255,255,.14)', padding: '1rem', borderRadius: 12 }}>
              <h3>{p.titre}</h3>
              <p>{p.description}</p>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
