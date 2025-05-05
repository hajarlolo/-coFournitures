CREATE DATABASE echange_scolaire;
USE echange_scolaire;
-- drop database  ;
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    CIN VARCHAR(20) NOT NULL UNIQUE,
    ville VARCHAR(100),
    quartier VARCHAR(100),
    photo_profil VARCHAR(255),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- select * from utilisateurs;
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    categorie VARCHAR(100),
    photo VARCHAR(255),
    statut ENUM('disponible', 'échangé') DEFAULT 'disponible',
    ville VARCHAR(100),
    quartier VARCHAR(100),
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);
-- delete from produits;
-- select * from produits;

INSERT INTO produits (id_utilisateur, titre, description, categorie, photo, statut, ville, quartier)
VALUES (1, 'Chaise ergonomique', 'Chaise de bureau ergonomique, très confortable pour de longues heures de travail. Ajustable avec accoudoirs et soutien lombaire.', 'Mobilier de bureau', 'chaise_ergonomique', 'disponible', 'Casablanca', 'Maarif');
INSERT INTO produits (id_utilisateur, titre, description, categorie, photo, statut, ville, quartier)
VALUES (1, 'Ordinateur portable HP', 'Ordinateur portable HP, modèle 15 pouces, processeur Intel i5, 8 Go de RAM, avec une autonomie de 10 heures.', 'Électronique', 'ordinateur_hp', 'disponible', 'Rabat', 'Agdal');
INSERT INTO produits (id_utilisateur, titre, description, categorie, photo, statut, ville, quartier)
VALUES (1, 'Sac à dos de randonnée', 'Sac à dos de grande capacité, résistant et imperméable, idéal pour les randonnées en montagne.', 'Accessoires de voyage', 'sac_a_dos_randonnee', 'disponible', 'Marrakech', 'Guéliz');

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_demandeur INT NOT NULL,
    date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en attente', 'accepté', 'refusé', 'terminé') DEFAULT 'en attente',
    FOREIGN KEY (id_produit) REFERENCES produits(id),
    FOREIGN KEY (id_demandeur) REFERENCES utilisateurs(id)
);
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expediteur_id INT NOT NULL,
    destinataire_id INT NOT NULL,
    message TEXT,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expediteur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (destinataire_id) REFERENCES utilisateurs(id)
);
CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_utilisateur INT NOT NULL,
    commentaire TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produit) REFERENCES produits(id),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);
