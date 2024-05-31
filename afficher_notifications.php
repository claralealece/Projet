<?php
// Connexion à la base de données
include 'dp.php';

// Récupérer toutes les notifications enregistrées
$sql = "SELECT * FROM notification";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Notifications</h1>";
    while($row = $result->fetch_assoc()) {
        echo "Nom: " . $row["nom"] . " - Type: " . $row["type_article"] . " - Rareté: " . $row["rarete"] . " - Prix max: " . $row["prix"] . " - Type de Vente: " . $row["type_vente"] . " - Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Aucune notification enregistrée.";
}

$conn->close();
?>
