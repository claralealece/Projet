-- Création de la base de données
CREATE DATABASE notifMail;

-- Sélection de la base de données
USE notifMail;

-- Création de la table 'article'
CREATE TABLE article (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    type_article ENUM('statue', 'vase', 'chaise') NOT NULL,
    rarete ENUM('regulier', 'rare', 'haut de gamme') NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    type_vente ENUM('immediate', 'negotiation', 'meilleure offre') NOT NULL,
    description TEXT,
    date_depot DATE NOT NULL,
    date_fin_enchere DATE
);

-- Création de la table 'notification'
CREATE TABLE notification (
    id_notif INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    type_vente ENUM('immediate', 'negotiation', 'meilleure offre') NOT NULL,
    rarete ENUM('regulier', 'rare', 'haut de gamme') NOT NULL,
    type_article ENUM('statue', 'vase', 'chaise') NOT NULL,
    email VARCHAR(255) NOT NULL
);
