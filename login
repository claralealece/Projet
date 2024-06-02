<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, type, email FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password, $db_type, $email);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['type'] = $db_type;
                // Après avoir vérifié le mot de passe et avant la redirection
                $_SESSION['email'] = $email; // Ajoutez cette ligne pour stocker l'email dans la session
                echo "Email récupéré : " . $_SESSION['email']; // Ajoutez cette ligne pour vérifier l'email dans la session

                header("Location: compte.php");
                exit();
            } else {
                header("Location: compte.php?error=1");
                exit();
            }
        } else {
            header("Location: compte.php?error=1");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: compte.php?error=1");
        exit();
    }

    $conn->close();
} else {
    header("Location: compte.php");
    exit();
}
?>
