<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $conn->real_escape_string($_POST['email']);
    $type = $conn->real_escape_string($_POST['type']);

    // Récupérer l'ID le plus récent
    $sql_last_id = "SELECT MAX(id) AS max_id FROM users";
    $result_last_id = $conn->query($sql_last_id);
    $last_id_row = $result_last_id->fetch_assoc();
    $last_id = ($last_id_row['max_id'] >= 5) ? $last_id_row['max_id'] + 1 : 5; // Si l'ID le plus récent est inférieur à 5, démarrer à 5

    $sql = "INSERT INTO users (id, username, password, email, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("issss", $last_id, $username, $password, $email, $type);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $type;
            header("Location: compte.php");
        } else {
            header("Location: compte.php?error=1");
        }

        $stmt->close();
    } else {
        header("Location: compte.php?error=1");
    }

    $conn->close();
} else {
    header("Location: compte.php");
}
?>
