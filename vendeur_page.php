<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'vendeur') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'agorafrancia1');
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $article_type = $conn->real_escape_string($_POST['article_type']);
    $categorie = $conn->real_escape_string($_POST['categorie']);
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $purchase_mode = $conn->real_escape_string($_POST['purchase_mode']);
    $max_date = isset($_POST['max_date']) ? $conn->real_escape_string($_POST['max_date']) : null;
    $description = $conn->real_escape_string($_POST['description']);
    $photos = $conn->real_escape_string($_POST['photos']);

    // Vérifier si le max_date doit être utilisé
    if ($purchase_mode !== 'enchère') {
        $max_date = null;
    }

    // Récupérer l'ID du vendeur en utilisant l'email
    $email_vendeur = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_vendeur);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vendeur_id = $row['id'];

        // Insertion des données dans la base de données
        $sql = "INSERT INTO articles (id_vendeur, type_article, categorie, titre, prix_vente, mode_achat, date_max, description, photo_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssdssss", $vendeur_id, $article_type, $categorie, $title, $price, $purchase_mode, $max_date, $description, $photos);
        
        if ($stmt->execute()) {
            echo "Nouvel article ajouté avec succès";

            // Vérification des notifications
            $sql = "SELECT * FROM notification 
                    WHERE type_article = ? 
                    AND rarete = ? 
                    AND type_vente = ? 
                    AND prix_max >= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssd", $categorie, $article_type, $purchase_mode, $price);
            $stmt->execute();
            $result = $stmt->get_result();

            // Initialisation des headers d'email
            $headers = "From: basile.pierre.lucas@gmail.com\r\n";

            if ($result->num_rows > 0) {
                while ($notif = $result->fetch_assoc()) {
                    // Envoyer la notification par email
                    $to = $notif['email'];
                    $subject = "Notification : Un article correspondant à vos critères a été trouvé !";
                    $message = "Un nouvel article correspondant à vos critères a été ajouté :\n";
                    $message .= "Titre: $title\n";
                    $message .= "Type: $categorie\n";
                    $message .= "Rareté: $article_type\n";
                    $message .= "Prix: $price\n";
                    $message .= "Type de Vente: $purchase_mode\n";

                    // Envoi de l'email
                    mail($to, $subject, $message, $headers);

                    // Affichage sur le site (pour test)
                    echo "Notification envoyée à {$to}:<br>{$message}<br>";
                }
            }
        } else {
            echo "Erreur: " . $stmt->error;
        }
    } else {
        echo "Erreur: Vendeur non trouvé";
    }

    // Fermeture de la connexion
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeur - Ajouter Article</title>
    <link rel="stylesheet" href="menu.css">
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
            <center><h1>Formulaire de Soumission d'Article</h1></center>
            <center>
                <form action="" method="post">
                    <label for="article-type">Type d'Article:</label>
                    <select id="article-type" name="article_type">
                        <option value="rare">Rare</option>
                        <option value="haut">Haut de gamme</option>
                        <option value="regulier">Régulier</option>
                    </select>
                    <br><br>

                    <label for="categorie">Catégorie de l'article:</label>
                    <select id="categorie" name="categorie">
                        <option value="vase">Vase</option>
                        <option value="statue">Statue</option>
                        <option value="potion">Potion</option>
                        <option value="divers">Divers</option>
                    </select>
                    <br><br>

                    <label for="title">Titre de l'Article:</label>
                    <input type="text" id="title" name="title" required>
                    <br><br>

                    <label for="price">Prix de Vente:</label>
                    <input type="number" id="price" name="price" step="1" min="0" required>
                    <br><br>
                    
                    <label for="purchase-mode">Mode d'Achat :</label>
                    <select id="purchase-mode" name="purchase_mode" onchange="toggleMaxDateField()">
                        <option value="achat_immediat">Achat Immédiat</option>
                        <option value="enchère">Enchère</option>
                        <option value="offre">Faire une Offre</option>
                    </select>
                    <br><br>

                    <div id="max-date-field" style="display: none;">
                        <label for="max-date">Date Max avant Fermeture de l'Enchère:</label>
                        <input type="date" id="max-date" name="max_date">
                        <br><br>
                    </div>

                    <label for="description">Description de l'article:</label>
                    <input type="text" id="description" name="description" required>
                    <br><br>

                    <label for="photos">Nom des Fichiers de Photos (séparés par des virgules):</label>
                    <input type="text" id="photos" name="photos" placeholder="ex: photo1.jpg,photo2.jpg" required>
                    <br><br>

                    <input type="submit" value="Soumettre l'Article">
                </form>
                <?php
                if ($_SESSION['type'] === 'vendeur') {
                    echo '<button onclick="window.location.href=\'mes_articles.php\'">Mes Articles</button>';
                }?>
            </center>
        </section>
        <footer class="footer">
            Droits d'auteur | Copyright © 2024, Boutique Antique, Athènes
        </footer>
    </div>
    <script>
        function toggleMaxDateField() {
            var purchaseMode = document.getElementById('purchase-mode').value;
            var maxDateField = document.getElementById('max-date-field');
            if (purchaseMode === 'enchère') {
                maxDateField.style.display = 'block';
            } else {
                maxDateField.style.display = 'none';
            }
        }
    </script>
</body>
</html>
