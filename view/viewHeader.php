<?php

    //creation de la classe viewHeader
    class ViewHeader {

        //ATTRIBUT
        private ?string $messageConnexion = "";

        //GETTER ET SETTER
        public function getMessageConnexion(): ?string {
            return $this->messageConnexion;
        }

        public function setMessageConnexion(?string $messageConnexion): ViewHeader {
                $this->messageConnexion = $messageConnexion;
                return $this;
        }

        //METHOD 
        public function displayView(): string {
            return 
                "<!DOCTYPE html>
                <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <link rel='icon' href='./Images/logo-site.webp' type='image/x-icon'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <meta name='description' content='Un site dédié à vous aider à trier facilement et rapidement vos déchets compostables. Découvrez en quelques clics comment simplifier le compostage et adopter des gestes écologiques au quotidien.'>
                    <link rel='preconnect' href='https://fonts.googleapis.com'>
                    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                    <link href='https://fonts.googleapis.com/css2?family=Cabin+Sketch:wght@400;700&family=Fredoka:wght@300..700&display=swap' rel='stylesheet'>
                    <link href='./styles/index.css' rel='stylesheet'>
                    <link href='./styles/commun.css' rel='stylesheet'>
                    <link href='./styles/administration.css' rel='stylesheet'>
                    <link href='./styles/connexionAdmin.css' rel='stylesheet'>
                    <title>Page - Administration</title>
                </head>
                <body>
                    <nav id='entete'>
                        <div class='leftMenu'>
                            <a href='index.php' alt='administration'>Ajout des déchet</a>
                            <a href='liens.html' alt='liens ressources'>Liens & Ressources</a>
                            <a href='logout.php' alt='bouton déconnexion'>Déconnexion</a>
                        </div>
                        <button type='button' aria-label='ouvre ferme menu gauche' class='menuToggler'>
                            <span class='line line1'></span>
                            <span class='line line2'></span>
                            <span class='line line3'></span>
                        </button>       
                    </nav>
                    <header>
                        <div id='logo'>
                            <h1>Ver'ify Compost</h1>
                            <a href='' alt='Retour à la page d'accueil' >
                                <picture>
                                    <source srcset='./Images/logo-site.webp' type='image/webp' />
                                    <source srcset='./Images/logo-site.png' type='image/png' /> 
                                    <img  id='retourAccueil' src='./Images/logo-site.png' alt='logo du site permettant de retourner à l'accueil'>
                                </picture>
                            </a>
                        </div>
                    </header>
                    <div class='leftMenuDesktop'>
                        <a class='lienMenuDesktop' href='index.php' alt='administration'>Ajout des déchet</a>
                        <a class='lienMenuDesktop' href='liens.html' alt='liens ressources'>Liens & Ressources</a>
                        <a class='lienMenuDesktop' href='logout.php' alt='contact'>Déconnexion</a>
                    </div>";
            }
    }
