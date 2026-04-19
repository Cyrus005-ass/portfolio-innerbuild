import { apiGet } from '../lib/api';
import { Hero } from '../components/sections/Hero';
import { About } from '../components/sections/About';
import { Skills } from '../components/sections/Skills';
import { Projects } from '../components/sections/Projects';
import { Certifications } from '../components/sections/Certifications';
import { Contact } from '../components/sections/Contact';
import type { Certification, Profile, Project, Skill } from '../lib/types';

export default async function HomePage() {
  const [profile, skills, projects, certifications] = await Promise.all([
    apiGet<Profile>('/profile'),
    apiGet<Skill[]>('/skills'),
    apiGet<Project[]>('/projects'),
    apiGet<Certification[]>('/certifications'),
  ]);

  return (
    <main>
      <Hero profile={profile} />
      <About profile={profile} />
      <Skills skills={skills} />
      <Projects projects={projects} />
      <Certifications certifications={certifications} />
      <Contact profile={profile} />
    </main>
  );
}
