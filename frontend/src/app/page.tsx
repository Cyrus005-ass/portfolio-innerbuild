import { apiGet } from '@/lib/api';
import { Hero } from '@/components/sections/Hero';
import { Projects } from '@/components/sections/Projects';

type Profile = {
  nom?: string;
  titre?: string;
  bio?: string;
};

type Project = {
  id: number;
  titre: string;
  description: string;
};

export default async function HomePage() {
  const profile = await apiGet<Profile>('/profile');
  const projects = await apiGet<Project[]>('/projects');

  return (
    <main>
      <Hero profile={profile} />
      <Projects projects={projects} />
    </main>
  );
}
