<?php
// Connexion à la base de données
include 'dp.php';

// Récupérer toutes les notifications enregistrées
$notifications = $conn->query("SELECT * FROM notification");

if ($notifications->num_rows > 0) {
    while ($notif = $notifications->fetch_assoc()) {
        // Construire la requête SQL pour trouver des articles correspondant aux critères
        $sql = "SELECT * FROM article 
                WHERE nom LIKE '%{$notif['nom']}%'
                AND type_article = '{$notif['type_article']}'
                AND rarete = '{$notif['rarete']}'
                AND type_vente = '{$notif['type_vente']}'
                AND prix <= {$notif['prix']}";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Envoyer la notification par email
            $to = $notif['email'];
            $subject = "Notification : Un article correspondant à vos critères a été trouvé !";
            $message = "Les articles suivants correspondent à vos critères :\n";

            while ($row = $result->fetch_assoc()) {
                $message .= "Nom: " . $row["nom"] . "\n";
                $message .= "Type: " . $row["type_article"] . "\n";
                $message .= "Rareté: " . $row["rarete"] . "\n";
                $message .= "Prix: " . $row["prix"] . "\n";
                $message .= "Type de Vente: " . $row["type_vente"] . "\n";
                $message .= "Description: " . $row["description"] . "\n\n";
            }

            // Envoi de l'email
            mail($to, $subject, $message);

            // Affichage sur le site (pour test)
            echo "Notification envoyée à {$to}:<br>{$message}<br>";
        }
    }
} else {
    echo "Aucune notification enregistrée.";
}

$conn->close();
?>
