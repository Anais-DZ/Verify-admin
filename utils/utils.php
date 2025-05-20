<?php

//Creation de la fonction connect()
function connect()
{
    return new PDO("mysql:host=" . getenv('bddhost') . ";dbname=" . getenv('bddname') . ";charset=utf8mb4", getenv('bddlogin'), getenv('bddpassword'), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

//Creation de la fonction clean()
// function clean($data) {
//     return htmlentities(strip_tags(stripslashes(trim($data))));
// }

// Nettoyage pour la BDD (pas d'encodage HTML, garde les accents)
function cleanForDB($data)
{
    return strip_tags(trim($data));
}

// Nettoyage pour l'affichage HTML (protège contre XSS)
function cleanForHTML($data) {
    return htmlentities($data, ENT_QUOTES, 'UTF-8');
}