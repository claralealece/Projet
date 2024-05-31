<?php
// Connexion à la base de données
include 'dp.php';

// Récupérer les critères de notification de l'utilisateur (par exemple, l'email)
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Récupérer les articles correspondant aux critères de notification de l'utilisateur
    $sql = "SELECT * FROM article WHERE id_article IN (
                SELECT DISTINCT a.id_article FROM article a
                INNER JOIN notification n ON a.nom LIKE CONCAT('%', n.nom, '%')
                WHERE n.email = '$email'
            )";

    $result = $conn->query($sql);

    // Vérifier s'il y a des articles correspondants
    if ($result->num_rows > 0) {
        echo "<h1>Articles correspondants aux critères de notification</h1>";
        while($row = $result->fetch_assoc()) {
            echo "Nom: " . $row["nom"]. " - Type: " . $row["type_article"]. " - Rareté: " . $row["rarete"]. " - Prix: " . $row["prix"]. " - Type de Vente: " . $row["type_vente"]. "<br>";
        }
    } else {
        echo "Aucun article ne correspond aux critères de notification.";
    }
} else {
    echo "Aucun email spécifié.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
