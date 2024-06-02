CREATE TABLE offres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    prix_offre DECIMAL(10, 2) NOT NULL,
    date_offre DATETIME NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);
