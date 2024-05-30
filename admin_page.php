<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'administrateur') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ajouter Article</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Ajouter un Article</h1>
            <div class="user-info">
                <?php echo "Connecté en tant que: " . htmlspecialchars($_SESSION['username']); ?>
            </div>
        </header>
        <nav class="navigation">
            <button onclick="window.location.href='index.php'">Accueil</button>
            <button onclick="window.location.href='toutparcourir.html'">Tout Parcourir</button>
            <button onclick="window.location.href='notification.php'">Notifications</button>
            <button onclick="window.location.href='panier.html'">Panier</button>
            <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['type'] === 'administrateur') {
                    echo '<button onclick="window.location.href=\'admin_page.php\'">Page Admin</button>';
                } elseif ($_SESSION['type'] === 'vendeur') {
                    echo '<button onclick="window.location.href=\'vendeur_page.php\'">Page Vendeur</button>';
                }
                echo '<button onclick="window.location.href=\'compte.php\'">Votre Compte</button>';
                echo '<button onclick="window.location.href=\'logout.php\'">Se déconnecter</button>';
            } else {
                echo '<button onclick="loadPage(\'account\')">Votre Compte</button>';
            }
            ?>
        </nav>
        <section>
            <center><h1>Formulaire de Soumission d'Article</h1></center>
            <center>
                <form action="submit_article.php" method="post">
                    <label for="article-type">Type d'Article:</label>
                    <select id="article-type" name="article_type">
                        <option value="statue">Rare</option>
                        <option value="vase">Haut de gamme</option>
                        <option value="divers">Régulier</option>
                    </select>
                    <br><br>

                    <label for="price">Prix de Vente:</label>
                    <input type="number" id="price" name="price" step="1" min="0" required>
                    <br><br>
                    
                    <label for="description">Description de l'article:</label>
                    <input type="text" id="description" name="description" required>
                    <br><br>

                    <label for="photos">Nom des Fichiers de Photos (séparés par des virgules):</label>
                    <input type="text" id="photos" name="photos" placeholder="ex: photo1.jpg,photo2.jpg" required>
                    <br><br>

                    <input type="submit" value="Soumettre l'Article">
                </form>
            </center>
        </section>
        <footer class="footer">
            Droits d'auteur | Copyright © 2024, Boutique Antique, Athènes
        </footer>
    </div>
</body>
</html>
