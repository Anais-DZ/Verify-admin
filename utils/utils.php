<?php 

    //Creation de la fonction connect()
    function connect() {
        return new PDO("mysql:host=" . getenv('bddhost') . ";dbname=" . getenv('bddname') . ";charset=utf8mb4",  getenv('bddlogin'),  getenv('bddpassword'), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    //Creation de la fonction clean()
    function clean($data) {
        return htmlentities(strip_tags(stripslashes(trim($data))));
    }