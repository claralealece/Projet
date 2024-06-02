<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'vendeur') {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'agorafrancia1');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'ID du vendeur connecté
$email_vendeur = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email_vendeur);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $vendeur_id = $row['id'];

    // Récupérer les articles du vendeur
    $sql_articles = "SELECT * FROM articles WHERE id_vendeur = ?";
    $stmt_articles = $conn->prepare($sql_articles);
    $stmt_articles->bind_param("i", $vendeur_id);
    $stmt_articles->execute();
    $result_articles = $stmt_articles->get_result();
} else {
    // Vendeur non trouvé
    echo "Erreur: Vendeur non trouvé";
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Articles</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="toutparcourir.css">

</head>
<body>
    <div class="wrapper">
        <header class="header">
            <img src="logo1.png" alt="Logo Agora">
            <h1>Agora Francia</h1>
            <div class="user-info">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Connecté en tant que: " . htmlspecialchars($_SESSION['username']);
                }
                ?>
            </div>
        </header>
        <nav class="navigation">
            <button onclick="window.location.href='index.php'">Accueil</button>
            <button onclick="window.location.href='toutparcourir.php'">Tout Parcourir</button>
            <button onclick="window.location.href='accueil_notif.html'">Notifications</button>
            <button onclick="window.location.href='panier.php'">Panier</button>
            <button onclick="window.location.href='vendeur_page.php'">Page Vendeur</button>
            <button onclick="window.location.href='compte.php'">Votre Compte</button>
            <button onclick="window.location.href='logout.php'">Se déconnecter</button>
        </nav>
        <section>
    <center><h1>Mes Articles</h1></center>
    <center>
        <?php
        // Afficher les articles du vendeur
        if ($result_articles->num_rows > 0) {
            while ($row_article = $result_articles->fetch_assoc()) {
                echo "<div>";
                echo "<h2>" . htmlspecialchars($row_article['titre']) . "</h2>";
                echo "<p>Catégorie: " . htmlspecialchars($row_article['categorie']) . "</p>";
                echo "<p>Prix: " . htmlspecialchars($row_article['prix_vente']) . "</p>";
                echo "<p>Description: " . htmlspecialchars($row_article['description']) . "</p>";
                // Afficher les photos en ligne par groupe de trois
                $photos = explode(",", $row_article['photo_url']);
                echo "<div class='photos-container'>";
                foreach ($photos as $photo) {
                    echo "<img src='" . htmlspecialchars($photo) . "' alt='Photo' class='article-photo'>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Aucun article trouvé.";
        }
        ?>
    </center>
</section>

        <footer class="footer">
            Droits d'auteur | Copyright © 2024, Boutique Antique, Athènes
        </footer>
    </div>
</body>
</html>