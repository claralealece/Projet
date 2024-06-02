-- Create the database
CREATE DATABASE IF NOT EXISTS agorafrancia1;
USE agorafrancia1;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE, -- Réduit à 191 caractères
    type VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL
);

-- Create the acheteur table
CREATE TABLE acheteur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adresse VARCHAR(255) NOT NULL,
    montant_disponible DECIMAL(10,2) NOT NULL,
    date_anniversaire DATE NOT NULL
);

-- Create the articles table
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_article VARCHAR(50) NOT NULL,
    prix_vente DECIMAL(15,2) NOT NULL,
    description TEXT NOT NULL,
    photo_url VARCHAR(255) NOT NULL,
    mode_achat VARCHAR(50) NOT NULL,
    titre VARCHAR(255) NOT NULL,
    date_max DATE,
    categorie VARCHAR(50) NOT NULL,
    id_vendeur INT NOT NULL,
    FOREIGN KEY (id_vendeur) REFERENCES users(id)
);

-- Create the notification table
CREATE TABLE notification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_article VARCHAR(255),
    type_article ENUM('statue', 'vase', 'potion', 'divers'),
    rarete ENUM('regulier', 'rare', 'haut'),
    type_vente ENUM('achat_immediat', 'enchère', 'offre'),
    prix_max DECIMAL(15,2),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(191) NOT NULL -- Réduit à 191 caractères
);

-- Create the offres table
CREATE TABLE offres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    prix_offre DECIMAL(10, 2) NOT NULL,
    date_offre DATETIME NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);
