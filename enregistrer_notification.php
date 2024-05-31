<?php
// Connexion à la base de données
include 'dp.php';

// Vérification si les données sont envoyées par le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les critères de notification
    $nom = $_POST['nom'];
    $type_article = $_POST['type_article'];
    $rarete = $_POST['rarete'];
    $type_vente = $_POST['type_vente'];
    $prix_max = $_POST['prix_max'];
    $email = $_POST['email'];

    // Préparer et lier les paramètres à la requête SQL
    $stmt = $conn->prepare("INSERT INTO notification (nom, prix, type_vente, rarete, type_article, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssss", $nom, $prix_max, $type_vente, $rarete, $type_article, $email);

    // Exécuter la requête et vérifier si elle réussit
    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
}

$conn->close();
?>
