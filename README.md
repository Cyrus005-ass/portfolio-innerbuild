# InnerBuild — Portfolio personnel premium

Portfolio one-page en PHP orienté **impact visuel**, **performance** et **gestion simple via admin**.
Le rendu visé s'inspire de l'approche de dennissnellenberg.com : storytelling, animations fluides, typographie forte, transitions soignées.

---

## 1) Objectif du projet

Construire un portfolio moderne qui met en valeur :
- le profil développeur,
- les compétences,
- les projets,
- les certifications,
- un contact direct,

avec un back-office pour administrer facilement le contenu.

---

## 2) Direction artistique cible

> Inspiration : `dennissnellenberg.com` (sans copie pixel-perfect).

Principes à respecter :
- **Narration visuelle** : homepage qui raconte un parcours (hero -> expertise -> preuves -> contact).
- **Motion design utile** : animations GSAP + ScrollTrigger + Locomotive Scroll au service du contenu.
- **Hiérarchie typographique forte** : gros titres, rythme vertical, micro-détails.
- **Look premium** : contraste propre, grilles maîtrisées, hover states précis.
- **Performance d'abord** : animations fluides sans sacrifier le temps de chargement.

---

## 3) Fonctionnalités attendues

### Front office
- Hero (nom, accroche, CTA, photo)
- À propos (histoire + valeurs)
- Compétences (tech + soft skills)
- Certifications (image/PDF, organisme, date, lien de vérification)
- Projets (2-4 projets phares)
- Contact (formulaire + message de confirmation)

### Back office
- Authentification admin
- Gestion certifications (CRUD + ordre + statut)
- Upload sécurisé (images + PDF)
- Gestion projets / profil / skills (selon avancement)

---

## 4) Stack technique

- **Backend** : PHP 8+
- **Base de données** : MySQL
- **DB actuelle** : `innerbuild_db`
- **Frontend** : HTML5, CSS3, JavaScript
- **Animations** : GSAP, ScrollTrigger, Locomotive Scroll
- **Environnement local** : WAMP

---

## 5) Arborescence actuelle

```txt
inner/
├── admin/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── public/
├── src/
│   ├── config/
│   ├── includes/
│   └── uploads/
└── templates/
    └── sections/
```

---

## 6) Installation locale

1. Placer le projet dans `C:\wamp64\www\inner`
2. Démarrer Apache + MySQL (WAMP)
3. Créer/importer la base de données : `innerbuild_db`
4. Configurer la connexion DB dans `src/config/config.php`
5. Vérifier les droits d'écriture sur `src/uploads/`
6. Ouvrir : `http://localhost/inner/public`

---

## 7) Configuration DB (template)

```php
<?php
return [
    'db_host' => '127.0.0.1',
    'db_name' => 'innerbuild_db',
    'db_user' => 'root',
    'db_pass' => '',
    'db_charset' => 'utf8mb4',
    'base_url' => 'http://localhost/inner/public',
];
```

---

## 8) Structure SQL cible (à compléter)

- `profil` : infos personnelles, bio, avatar
- `skills` : nom, niveau, type, ordre
- `projets` : titre, description, stack, image, lien, ordre, statut
- `certifications` : titre, organisme, date_obtention, image, pdf, verification_url, ordre, actif
- `messages` : nom, email, sujet, message, created_at
- `admins` : email, mot_de_passe_hash, role, last_login

---

## 9) Sécurité minimale requise

- Requêtes préparées PDO
- Validation + sanitation des entrées
- Contrôle MIME réel côté serveur
- Renommage des fichiers uploadés
- Limite de taille upload
- Protection session admin (timeout + regeneration id)
- Token CSRF sur formulaires sensibles

---

## 10) Checklist design (style premium)

- [ ] Hero plein écran avec message fort
- [ ] Scroll smooth calibré (desktop/mobile)
- [ ] Titres à forte personnalité
- [ ] Transitions section-to-section cohérentes
- [ ] Section Certifications en grille moderne
- [ ] Hover states précis (projets/certifs)
- [ ] CTA visible et répétée intelligemment
- [ ] Footer sobre et pro

---

## 11) État d'avancement

- [x] Base du projet en place
- [x] DB créée : `innerbuild_db`
- [ ] Intégration visuelle haut de gamme finalisée
- [ ] Admin finalisé (CRUD complet)
- [ ] Optimisation performance (Lighthouse)
- [ ] Mise en production

---

## 12) Roadmap

### v1.0
- Finaliser homepage one-page premium
- Finaliser admin certifications + projets
- Stabiliser sécurité et uploads

### v1.1
- Filtrage dynamique projets/certifs
- Amélioration animations avancées

### v1.2
- Version bilingue FR/EN
- Dashboard admin avec statistiques

---

## 13) Déploiement (pré-prod / prod)

- [ ] Config `APP_ENV=production`
- [ ] Désactiver affichage erreurs PHP
- [ ] Activer HTTPS
- [ ] Configurer backups DB
- [ ] Vérifier permissions dossiers uploads
- [ ] Tester formulaire contact en réel

---

## 14) Auteur

- **Nom** : Cyrus-y ASSOGBA
- **Rôle** : Développeur Web Full-Stack & UI/UX Designer
- **Localisation** : Bénin
- **Portfolio** : `<a-completer>`
- **LinkedIn** : `<a-completer>`
- **Email** : `<a-completer>`

---

## 15) Licence

`A définir` (MIT, propriétaire, etc.)
