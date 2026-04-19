import type { Skill } from '../../lib/types';

type GroupedSkills = Record<string, Skill[]>;

export function Skills({ skills }: { skills: Skill[] }) {
  const grouped = skills.reduce<GroupedSkills>((acc, skill) => {
    const key = skill.categorie || 'Autres';
    acc[key] = acc[key] || [];
    acc[key].push(skill);
    return acc;
  }, {});

  return (
    <section id="skills" className="skills-section">
      <div className="container">
        <h2 className="section-title section-title-tight">Mon Expertise</h2>
        <div className="skills-layout">
          {Object.entries(grouped).map(([category, items]) => (
            <article key={category} className="skill-category">
              <h3 className="skill-category-title">{category}</h3>
              <ul className="skill-list">
                {items.map((skill) => (
                  <li key={skill.id} className="skill-item">
                    <span className="skill-pill">
                      {skill.nom}
                      <small>{Number.isFinite(skill.niveau) ? `${skill.niveau}%` : ''}</small>
                    </span>
                  </li>
                ))}
              </ul>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
