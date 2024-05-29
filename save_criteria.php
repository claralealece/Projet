<?php
$user_name = "root"; 
$password = ""; 
$database = "critere"; 
$server = "127.0.0.1"; 

// Connexion au serveur MySQL
$db_handle = mysqli_connect($server, $user_name, $password);

if (!$db_handle) {
    die("Échec de la connexion au serveur : " . mysqli_connect_error());
}
echo "Connexion au serveur réussie.<br>";

// Sélection de la base de données
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
    echo "Connexion à la base de données réussie.<br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $item = $_POST['item'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $condition = $_POST['condition'];

        // Préparer et lier
        $stmt = $db_handle->prepare("INSERT INTO criteres (item, category, price, `condition`) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die('Erreur de préparation : ' . htmlspecialchars($db_handle->error));
        }

        $bind = $stmt->bind_param("ssds", $item, $category, $price, $condition);
        if ($bind === false) {
            die('Erreur de liaison des paramètres : ' . htmlspecialchars($stmt->error));
        }

        if ($stmt->execute()) {
            echo "Nouveaux critères ajoutés avec succès";
        } else {
            echo "Erreur: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
} else {
    echo "Échec de la connexion à la base de données.";
}

// Fermer la connexion
mysqli_close($db_handle);
?>

