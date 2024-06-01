<?php

$to = "claraleal075@gmail.com";
$subject = "Utilisation de mail() avec PHP depuis Windows";
$message = "Salut, comment ça va ? ";

$headers = "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "From: basile.pierre.lucas@gmail.com\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo 'Envoyé !';
} else {
    echo 'Erreur envoi';
}
?>
