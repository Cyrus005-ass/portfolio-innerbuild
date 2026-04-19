export type Profile = {
  id?: number;
  nom?: string;
  titre?: string;
  bio?: string;
  avatar?: string | null;
  cv_url?: string | null;
  email_contact?: string;
  telephone?: string | null;
  linkedin?: string | null;
  github?: string | null;
  instagram?: string | null;
  localisation?: string | null;
};

export type Skill = {
  id: number;
  nom: string;
  categorie: string;
  niveau: number;
  ordre?: number;
};

export type Project = {
  id: number;
  titre: string;
  description: string;
  technologies?: string | null;
  image?: string | null;
  lien_live?: string | null;
  lien_github?: string | null;
  annee?: string | null;
};

export type Certification = {
  id: number;
  nom: string;
  organisme: string;
  date_obtention?: string | null;
  lien_verification?: string | null;
  photo?: string | null;
};
