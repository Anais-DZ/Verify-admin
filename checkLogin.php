<?php

    // Démarrage de la session
    session_start();

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION["id_user"])) {
        // Redirige vers la page de connexion
        header("Location: identificationUser.php"); 
        exit();
    }
?>
