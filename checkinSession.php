<?php

// Démarrage de la session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["id_user"])) {
    // Redirige vers la page de connexion
    header("Location: index.php");
    exit();
}

// Déclaration du temps de durée de session (5min)
$timeout = 300;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {

    // Supprime toutes les variables de session
    session_unset();

    // Détruit la session
    session_destroy();

    // redirection vers page de login
    header("Location: index.php");
    exit();
}

// mise à jour de l’activité
$_SESSION['LAST_ACTIVITY'] = time();

?>