<?php
    session_start();
    include 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Articles Achat Immédiat</title>

    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="toutparcourir.css">

    <script>
        function showModal(id) {
            document.getElementById(id).style.display = 'block';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <img src="logo1.png" class="img">
            <h1>Agora Francia</h1>
        </header>

        <nav class="navigation">
            <button><a href="index.php">Accueil</a></button>
            <button>
                <div class="dropdown">
                    <a href="toutparcourir.php">Tout Parcourir</a>
                    <div class="dropdown-content">
                        <a href="articles_rares.php">Articles rares</a>
                        <a href="articles_haut.php">Articles haut de gamme</a>
                        <a href="articles_reguliers.php">Articles réguliers</a>
                    </div>
                </div>
            </button>
            <button><a href="notification.html">Notifications</a></button>
            <button><a href="panier.php">Panier</a></button>
            <button><a href="moncompte.php">Votre Compte</a></button>
        </nav>
        
        <section class="page">
            <center><p1> Ici vous découvrirez nos articles en achat immédiat ! </p1></center>

            <p><br> Attention ! Pour les potions il est ESSENTIEL de respecter les doses prescrites car les conséquences d'un usage excessif peuvent être imprévisibles et potentiellement dangereuses. Une utilisation inappropriée d'une de ces potions pourrait entraîner des effets plus qu'indésirables... </p>

            <center><p1> <br> A vos risques et périls...</p1></center>

            <br><br><br>

            <div class="gallery">
                <?php
                    $sql = "SELECT id, titre, description, prix_vente, photo_url FROM articles WHERE mode_achat = 'achat_immediat'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <figure>
                                <a href="<?php echo $row["photo_url"]; ?>" data-lightbox="gallery" data-title="Description de l'article achat immédiat">
                                    <img src="<?php echo $row["photo_url"]; ?>" alt="<?php echo $row["titre"]; ?>">
                                </a>
                                <figcaption><?php echo $row["titre"]; ?></figcaption>
                                <button onclick="showModal('<?php echo 'modal' . $row["id"]; ?>')">En savoir plus</button>
                                <div id="<?php echo 'modal' . $row["id"]; ?>" class="modal">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal('<?php echo 'modal' . $row["id"]; ?>')">&times;</span>
                                        <center><h2><?php echo $row["titre"]; ?></h2></center>
                                        <p><?php echo $row["description"]; ?></p>
                                        <p><strong><br>Prix : <?php echo $row["prix_vente"]; ?> €</strong></p>
                                        <form action="panier.php" method="post">
                                            <input type="hidden" name="action" value="ajouter">
                                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                            <input type="hidden" name="titre" value="<?php echo $row["titre"]; ?>">
                                            <input type="hidden" name="prix_vente" value="<?php echo $row["prix_vente"]; ?>">
                                            <input type="hidden" name="photo_url" value="<?php echo $row["photo_url"]; ?>">
                                            <button type="submit">Ajouter au panier</button>
                                        </form>
                                    </div>
                                </div>
                            </figure>
                            <?php
                        }
                    } else {
                        echo "Aucun article en achat immédiat trouvé.";
                    }
                    $conn->close();
                ?>
            </div>

        </section>

        <footer class="footer">
            <p>Droits d'auteur | Copyright © 2024, Boutique d'antiquités, Athènes</p>
        </footer>
    </div>
</body>
</html>
