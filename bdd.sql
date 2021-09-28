-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 06 Juillet 2021 à 16:09
-- Version du serveur :  5.7.34-0ubuntu0.18.04.1
-- Version de PHP :  7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  esuria_portfolio
--

-- --------------------------------------------------------

--
-- Structure de la table acteur
--

CREATE TABLE acteur (
  id int(11) NOT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  role varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table article
--

CREATE TABLE article (
  id int(11) NOT NULL,
  image_id int(11) NOT NULL,
  titre varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  date date NOT NULL,
  texte longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  type varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  path varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table article
--

INSERT INTO article (id, image_id, titre, date, texte, description, type, path) VALUES
(1, 5, 'test-de-folie', '2019-09-01', '<p>test</p>', 'test', 'agenda', 'test'),
(2, 6, 'Réparation du Blog', '2019-09-23', '<p>JE vais &eacute;crire un text sans descritpnio</p>', 'elle est olbgksfkl', 'realisation', 'caca-boudin');

-- --------------------------------------------------------

--
-- Structure de la table biographie
--

CREATE TABLE biographie (
  id int(11) NOT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  presentation longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table biographie
--

INSERT INTO biographie (id, nom, prenom, presentation) VALUES
(1, 'Oulerich', 'Loic', 'oui');

-- --------------------------------------------------------

--
-- Structure de la table commentaire
--

CREATE TABLE commentaire (
  id int(11) NOT NULL,
  article_id int(11) NOT NULL,
  user_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  texte longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  date datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table episode
--

CREATE TABLE episode (
  id int(11) NOT NULL,
  saison_id int(11) DEFAULT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  numero int(11) NOT NULL,
  duree int(11) NOT NULL,
  date datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table event
--

CREATE TABLE event (
  id int(11) NOT NULL,
  titre varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  date int(11) NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table event
--

INSERT INTO event (id, titre, date, description) VALUES
(1, 'Lycée charle', 2020, 'tets de soluble'),
(2, 'test', 2027, 'voiture');

-- --------------------------------------------------------

--
-- Structure de la table hobbies
--

CREATE TABLE hobbies (
  id int(11) NOT NULL,
  image_id int(11) NOT NULL,
  link varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table image
--

CREATE TABLE image (
  id int(11) NOT NULL,
  projects_id int(11) DEFAULT NULL,
  filename varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  path varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  alt varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table image
--

INSERT INTO image (id, projects_id, filename, path, alt) VALUES
(1, NULL, '9ffa632fd906bb27473d79214eb08839.png', 'uploads/Thumbnail/9ffa632fd906bb27473d79214eb08839.png', 'teszt'),
(2, NULL, '230b086fec252c69c00e206bd816f9a4.png', 'uploads/Thumbnail/230b086fec252c69c00e206bd816f9a4.png', 'test'),
(3, NULL, '05c8861ef97b223fcecedca2ac0bd815.png', 'uploads/Thumbnail/05c8861ef97b223fcecedca2ac0bd815.png', 'test'),
(4, NULL, '2400d2576481a2435424f7430d0ba411.jpeg', 'uploads/Thumbnail/2400d2576481a2435424f7430d0ba411.jpeg', 'test'),
(5, NULL, 'ccc2a1ff3f2e7811d01d3e5b15538425.png', 'uploads/Thumbnail/ccc2a1ff3f2e7811d01d3e5b15538425.png', 'test'),
(6, NULL, '16492985719369c1a3cf9925b92d3a56.png', 'uploads/Thumbnail/16492985719369c1a3cf9925b92d3a56.png', 'gsf');

-- --------------------------------------------------------

--
-- Structure de la table personnage
--

CREATE TABLE personnage (
  id int(11) NOT NULL,
  acteur_id int(11) NOT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table projects
--

CREATE TABLE projects (
  id int(11) NOT NULL,
  banner_id int(11) DEFAULT NULL,
  miniature_id int(11) DEFAULT NULL,
  title varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  client varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  categorie varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  techno varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  url_site varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  status varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  date date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table projects
--

INSERT INTO projects (id, banner_id, miniature_id, title, description, client, categorie, techno, url_site, status, date) VALUES
(1, 1, 2, 'test2', 'test', 'tedst', 'web', 'test', 'test', 'fini', '2019-09-10'),
(2, 3, 4, 'test', 'test', 'test', 'video', 'test', 'test', 'fini', '2019-09-11');

-- --------------------------------------------------------

--
-- Structure de la table projects_technologies
--

CREATE TABLE projects_technologies (
  projects_id int(11) NOT NULL,
  technologies_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table projects_technologies
--

INSERT INTO projects_technologies (projects_id, technologies_id) VALUES
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table saison
--

CREATE TABLE saison (
  id int(11) NOT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  date datetime NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table saison_personnage
--

CREATE TABLE saison_personnage (
  saison_id int(11) NOT NULL,
  personnage_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table skill
--

CREATE TABLE skill (
  id int(11) NOT NULL,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  icone varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table skill
--

INSERT INTO skill (id, name, icone) VALUES
(1, 'test', '<i class=\"fab fa-symfony\"></i>');

-- --------------------------------------------------------

--
-- Structure de la table small_event
--

CREATE TABLE small_event (
  id int(11) NOT NULL,
  event_id int(11) NOT NULL,
  titre varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  date datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table small_event
--

INSERT INTO small_event (id, event_id, titre, description, date) VALUES
(1, 1, 'test de smallEvent', 'test', '2019-09-11 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table technologies
--

CREATE TABLE technologies (
  id int(11) NOT NULL,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  icon varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table technologies
--

INSERT INTO technologies (id, name, icon) VALUES
(3, 'Symfony', '<i class=\"fab fa-css3\"></i>');

-- --------------------------------------------------------

--
-- Structure de la table user
--

CREATE TABLE user (
  id int(11) NOT NULL,
  email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  username varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  nom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  roles tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  is_active tinyint(1) NOT NULL,
  confirmation_token varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  confirmation_reset_password_token varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  password varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table acteur
--
ALTER TABLE acteur
  ADD PRIMARY KEY (id);

--
-- Index pour la table article
--
ALTER TABLE article
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY UNIQ_23A0E663DA5256D (image_id);

--
-- Index pour la table biographie
--
ALTER TABLE biographie
  ADD PRIMARY KEY (id);

--
-- Index pour la table commentaire
--
ALTER TABLE commentaire
  ADD PRIMARY KEY (id),
  ADD KEY IDX_67F068BC7294869C (article_id);

--
-- Index pour la table episode
--
ALTER TABLE episode
  ADD PRIMARY KEY (id),
  ADD KEY IDX_DDAA1CDAF965414C (saison_id);

--
-- Index pour la table event
--
ALTER TABLE event
  ADD PRIMARY KEY (id);

--
-- Index pour la table hobbies
--
ALTER TABLE hobbies
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY UNIQ_38CA341D3DA5256D (image_id);

--
-- Index pour la table image
--
ALTER TABLE image
  ADD PRIMARY KEY (id),
  ADD KEY IDX_C53D045F1EDE0F55 (projects_id);

--
-- Index pour la table personnage
--
ALTER TABLE personnage
  ADD PRIMARY KEY (id),
  ADD KEY IDX_6AEA486DDA6F574A (acteur_id);

--
-- Index pour la table projects
--
ALTER TABLE projects
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY UNIQ_5C93B3A4684EC833 (banner_id),
  ADD UNIQUE KEY UNIQ_5C93B3A4903C60DB (miniature_id);

--
-- Index pour la table projects_technologies
--
ALTER TABLE projects_technologies
  ADD PRIMARY KEY (projects_id,`technologies_id`),
  ADD KEY IDX_2590E7421EDE0F55 (projects_id),
  ADD KEY IDX_2590E7428F8A14FA (technologies_id);

--
-- Index pour la table saison
--
ALTER TABLE saison
  ADD PRIMARY KEY (id);

--
-- Index pour la table saison_personnage
--
ALTER TABLE saison_personnage
  ADD PRIMARY KEY (saison_id,`personnage_id`),
  ADD KEY IDX_416C05CAF965414C (saison_id),
  ADD KEY IDX_416C05CA5E315342 (personnage_id);

--
-- Index pour la table skill
--
ALTER TABLE skill
  ADD PRIMARY KEY (id);

--
-- Index pour la table small_event
--
ALTER TABLE small_event
  ADD PRIMARY KEY (id),
  ADD KEY IDX_A8404BC471F7E88B (event_id);

--
-- Index pour la table technologies
--
ALTER TABLE technologies
  ADD PRIMARY KEY (id);

--
-- Index pour la table user
--
ALTER TABLE user
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY UNIQ_8D93D649E7927C74 (email);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table acteur
--
ALTER TABLE acteur
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table article
--
ALTER TABLE article
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table biographie
--
ALTER TABLE biographie
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table commentaire
--
ALTER TABLE commentaire
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table episode
--
ALTER TABLE episode
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table event
--
ALTER TABLE event
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table hobbies
--
ALTER TABLE hobbies
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table image
--
ALTER TABLE image
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table personnage
--
ALTER TABLE personnage
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table projects
--
ALTER TABLE projects
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table saison
--
ALTER TABLE saison
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table skill
--
ALTER TABLE skill
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table small_event
--
ALTER TABLE small_event
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table technologies
--
ALTER TABLE technologies
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table user
--
ALTER TABLE user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table article
--
ALTER TABLE article
  ADD CONSTRAINT FK_23A0E663DA5256D FOREIGN KEY (image_id) REFERENCES image (id);

--
-- Contraintes pour la table commentaire
--
ALTER TABLE commentaire
  ADD CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES article (id);

--
-- Contraintes pour la table episode
--
ALTER TABLE episode
  ADD CONSTRAINT FK_DDAA1CDAF965414C FOREIGN KEY (saison_id) REFERENCES saison (id);

--
-- Contraintes pour la table hobbies
--
ALTER TABLE hobbies
  ADD CONSTRAINT FK_38CA341D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id);

--
-- Contraintes pour la table image
--
ALTER TABLE image
  ADD CONSTRAINT FK_C53D045F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE SET NULL;

--
-- Contraintes pour la table personnage
--
ALTER TABLE personnage
  ADD CONSTRAINT FK_6AEA486DDA6F574A FOREIGN KEY (acteur_id) REFERENCES acteur (id);

--
-- Contraintes pour la table projects
--
ALTER TABLE projects
  ADD CONSTRAINT FK_5C93B3A4684EC833 FOREIGN KEY (banner_id) REFERENCES image (id) ON DELETE SET NULL,
  ADD CONSTRAINT FK_5C93B3A4903C60DB FOREIGN KEY (miniature_id) REFERENCES image (id) ON DELETE SET NULL;

--
-- Contraintes pour la table projects_technologies
--
ALTER TABLE projects_technologies
  ADD CONSTRAINT FK_2590E7421EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE,
  ADD CONSTRAINT FK_2590E7428F8A14FA FOREIGN KEY (technologies_id) REFERENCES technologies (id) ON DELETE CASCADE;

--
-- Contraintes pour la table saison_personnage
--
ALTER TABLE saison_personnage
  ADD CONSTRAINT FK_416C05CA5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE,
  ADD CONSTRAINT FK_416C05CAF965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON DELETE CASCADE;

--
-- Contraintes pour la table small_event
--
ALTER TABLE small_event
  ADD CONSTRAINT FK_A8404BC471F7E88B FOREIGN KEY (event_id) REFERENCES event (id);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
