<?php
// Connexion à la base de données
include 'dp.php';

// Vérifier si les données sont envoyées par le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données de l'article
    $nom = $_POST['nom'];
    $type_article = $_POST['type_article'];
    $rarete = $_POST['rarete'];
    $type_vente = $_POST['type_vente'];
    $prix = $_POST['prix'];

    // Préparer et lier les paramètres à la requête SQL pour insérer l'article
    $stmt = $conn->prepare("INSERT INTO article (nom, type_article, rarete, prix, type_vente, date_depot) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssds", $nom, $type_article, $rarete, $prix, $type_vente);

    // Exécuter la requête et vérifier si elle réussit
    if ($stmt->execute()) {
        echo "Article ajouté avec succès !<br>";

        // Vérifier les notifications
        $sql = "SELECT * FROM notification 
                WHERE nom LIKE '%$nom%' 
                AND type_article='$type_article' 
                AND rarete='$rarete' 
                AND type_vente='$type_vente' 
                AND prix >= $prix";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($notif = $result->fetch_assoc()) {
                // Envoyer la notification par email
                $to = $notif['email'];
                $subject = "Notification : Un article correspondant à vos critères a été trouvé !";
                $message = "Un nouvel article correspondant à vos critères a été ajouté :\n";
                $message .= "Nom: $nom\n";
                $message .= "Type: $type_article\n";
                $message .= "Rareté: $rarete\n";
                $message .= "Prix: $prix\n";
                $message .= "Type de Vente: $type_vente\n";

                // Envoi de l'email
                 

                // Affichage sur le site (pour test)
                echo "Notification envoyée à {$to}:<br>{$message}<br>";
            }
        }
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
}

$conn->close();
?>
