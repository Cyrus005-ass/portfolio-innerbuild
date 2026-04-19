type Profile = {
  nom?: string;
  titre?: string;
  bio?: string;
};

export function Hero({ profile }: { profile: Profile }) {
  return (
    <section id="hero">
      <div className="container">
        <h1>{profile.nom || 'Portfolio'}</h1>
        <p>{profile.titre || 'Developpeur web'}</p>
      </div>
    </section>
  );
}
