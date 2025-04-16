<?php 

    //Creation de la fonction connect()
    function connect() {
        return new PDO("mysql:host=". $_ENV ['bddhost']. ";dbname=" . $_ENV ['bddname'] . ";charset=utf8mb4", $_ENV ['bddlogin'] , $_ENV ['bddpassword'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    //Creation de la fonction clean()
    function clean($data) {
        return htmlentities(strip_tags(stripslashes(trim($data))));
    }