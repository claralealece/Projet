<?php
include 'db.php'; // Inclut le fichier db.php qui contient la connexion à la base de données

// Récupération des données du formulaire
$article_type = $_POST['article_type'];
$title = $_POST['title'];
$price = $_POST['price'];
$purchase_mode = $_POST['purchase_mode'];
$max_date = isset($_POST['max_date']) ? $_POST['max_date'] : null;
$description = $_POST['description'];
$photos = $_POST['photos']; // Noms des fichiers de photos, séparés par des virgules
$categorie = $_POST['categorie']; // Récupération de la catégorie

// Gestion des photos
$photo_files = explode(',', $photos); // Diviser les noms de fichiers par virgule
$photo_paths = array_map('trim', $photo_files); // Enlever les espaces autour des noms de fichiers

// Préparation de la requête SQL pour insérer les données de l'article
// On suppose que la table Articles a une colonne photo_paths qui peut contenir les noms des photos séparés par des virgules
$sql = "INSERT INTO Articles (type_article, titre, prix_vente, mode_achat, date_max, description, photo_url, categorie) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$photo_paths_str = implode(',', $photo_paths); // Convertir le tableau de chemins de photos en une chaîne de caractères séparée par des virgules
$stmt->bind_param("ssdsssss", $article_type, $title, $price, $purchase_mode, $max_date, $description, $photo_paths_str, $categorie);

if ($stmt->execute() === TRUE) {
    $article_id = $stmt->insert_id; // Récupérer l'ID de l'article inséré

    // Générer le contenu HTML pour le nouvel article
    $new_article_html = "<figure>
                            <a href='" . htmlspecialchars($photo_paths[0]) . "' data-lightbox='gallery' data-title='" . htmlspecialchars($description) . "'><img src='" . htmlspecialchars($photo_paths[0]) . "' alt='Image de l\'article'></a>
                            <figcaption>" . htmlspecialchars($title) . " - " . htmlspecialchars($description) . " - " . htmlspecialchars($price) . "€</figcaption>
                         </figure>";

    $file_to_update = '';
    if ($article_type == 'rare') {
        $file_to_update = 'articles_rares.html';
    } elseif ($article_type == 'haut') {
        $file_to_update = 'articles_haut_de_gamme.html';
    } elseif ($article_type == 'regulier') {
        $file_to_update = 'articles_reguliers.html';
    }

    if ($file_to_update) {
        file_put_contents($file_to_update, $new_article_html, FILE_APPEND);
    }

    echo "Nouvel article créé avec succès. ID: " . $article_id . "<br>";
    echo "Photos ajoutées à la base de données : " . $photo_paths_str . "<br>";

    echo "<a href='moncompte.php'>Retour au site</a>";
} else {
    echo "Erreur : " . $sql . "<br>" . $stmt->error;
}

$stmt->close();
$conn->close();
?>