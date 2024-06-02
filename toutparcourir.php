<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Tout Parcourir</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="toutparcourir.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script>
    function scrollToSection() {
        var browseSection = document.querySelector('.page');
        if (browseSection) {
            browseSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            console.error("Section not found");
        }
    }

    function scrollToBottom() {
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }

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
            <button><a href="accueil_notif.html">Notifications</a></button>
            <button><a href="panier.php">Panier</a></button>
            <button><a href="compte.php">Votre Compte</a></button>
            <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['type'] === 'administrateur') {
                    echo '<button><a href="admin_page.php">Page Admin</a></button>';
                } elseif ($_SESSION['type'] === 'vendeur') {
                    echo '<button><a href="vendeur_page.php">Page Vendeur</a></button>';
                }
                echo '<button><a href="logout.php">Se déconnecter</a></button>';
            }
            ?>
        </nav>
        
        <section class="page">
            <center><p> Bienvenue à tous chers collectionneurs !</p></center>
            <br><br>
            <p> Laissez vous transporter dans le monde de la Grèce Antique, celui-ci vous réserve de nombreuses surprises...</p>

            <br><br>
    
            <div class="centered-image">
                <img src="image.jpg" alt="Description de l'image">
                <button onclick="scrollToBottom()">Tout découvrir</button>
            </div>

            <br><br>

            <p>Quel mode de paiement vous intéresse ?</p><br>
            <div class="navigation">
                <center><button><a href="articles_enchere.php">Enchères</a></button>
                <button><a href="articles_offres.php">Transaction Vendeur-Client</a></button>
                <button><a href="articles_achat_immediat.php">Achat immédiat</a></button></center>
            </div>
            <p>Voici un exemple d'article que vous pouvez trouver dans chaque catégorie...</p>

            <br><br><br>

            <div class="gallery">
                <figure>
                    <a href="potion3.jpg" data-lightbox="gallery" data-title="Description de l'image 1">
                        <img src="potion3.jpg" alt="Image 1" class="article-image">
                    </a>
                    <figcaption> Articles rares </figcaption>
                    <button onclick="showModal('modal1')">En savoir plus</button>
                    <div id="modal1" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('modal1')">&times;</span>
                            <center><h2> Articles rares </h2></center>
                            <p> <br> Découvrez notre sélection d'articles rares !</p>
                        </div>
                    </div>
                </figure>

                <figure>
                    <a href="medusa.jpg" data-lightbox="gallery" data-title="Description de l'image 2"><img src="medusa.jpg" alt="Image 2" class="article-image"></a>
                    <figcaption> Articles haut de gamme </figcaption>
                    <button onclick="showModal('modal2')">En savoir plus</button>
                    <div id="modal2" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('modal2')">&times;</span>
                            <center><h2> Articles haut de gamme </h2></center>
                            <p> <br> Découvrez notre sélection d'articles haut de gamme ! </p>
                        </div>
                    </div>
                </figure>
                <figure>
                    <a href="harpe.jpg" data-lightbox="gallery" data-title="Description de l'image 3"><img src="harpe.jpg" alt="Image 3" class="article-image"></a>
                    <figcaption> Articles réguliers </figcaption>
                    <button onclick="showModal('modal3')">En savoir plus</button>
                    <div id="modal3" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('modal3')">&times;</span>
                            <center><h2> Articles réguliers </h2></center>
                            <p> <br> Découvrez notre sélection d'articles réguliers !</p>
                        </div>
                    </div>
                </figure>
            </div>

            <p> Bonne expérience ! </p>
        </section>

        <footer class="footer">
            <p>Droits d'auteur | Copyright © 2024, Boutique d'antiquités, Athènes</p>
        </footer>
    </div>
</body>
</html>
