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
                    <link href='./styles/inscription.css' rel='stylesheet'>
                    <link href='./styles/formulaire.css' rel='stylesheet'>
                    <link href='./styles/administration.css' rel='stylesheet'>
                    <title>Page - Administration</title>
                </head>
                <body>
                    <nav id='entete'>
                        <div class='leftMenu'>
                            <a href='index.html' alt='accueil'>Accueil</a>
                            <a href='#calendarFonctionnality' alt='calendrier memo'>Calendrier</a>
                            <a href='adminWaste.php' alt='administration'>Déchet</a>
                            <a href='guide.html' alt='guide entretien'>Conseils & entretien</a>
                            <a href='liens.html' alt='liens ressources'>Liens & Ressources</a>
                            <a href='compte.html' alt='mon compte'>Mon compte</a>
                            <a id='deconnexion' href='construction.html' alt='deconnexion'><img src='./Icones/off.png' alt='bouton deconnexion'>Déconnexion</a>
                        </div>
                        <button type='button' aria-label='ouvre ferme menu gauche' class='menuToggler'>
                            <span class='line line1'></span>
                            <span class='line line2'></span>
                            <span class='line line3'></span>
                        </button>
                        <a href='#calendarFonctionnality' alt='calendrier memo'><img id='calendar' src='./Icones/calendar.png' alt='Logo calendrier'></a>
                        <form method='post' action='' autocomplete='on'>
                            <fieldset class='rightMenu'>
                                
                                <h2>Connexion</h2>
                                <div class='separation'></div>
                                <p id='constructionButton'>(Le site étant actuellement en développement, il n'est pas encore possible de se connecter, s'inscrire ou envoyer un message).</p>
                                <div>
                                    <label for='name'>Votre identifiant</label>
                                    <input type='text' name='identifiant' placeholder='Entrez votre identifiant' minlength='2' maxlength='25' id='name' required autocomplete='on'>
                                    <div id='identifiantMenuError'></div>
                                </div>
                                <div>
                                    <label for='passwordMenu'>Votre mot de passe</label>
                                    <input type='password' name='password' placeholder='Entrez votre mot de passe' minlength='2' maxlength='25' id='passwordMenu' autocomplete='on' required>
                                    <div id='passwordMenuError'></div>
                                </div>
                                <div class='checkboxContainer'>
                                    <input type='checkbox' id='checkbox' checked />
                                    <label for='checkbox'>Se souvenir de moi</label>
                                </div>
                                <button type='submit' id='submitButtonMenu' disabled>Se connecter</button>
                                <p>Nouvel·le arrivant·e ?
                                    Par <a href='inscription.html' alt='lien page inscription'>ici !</a></p>
                                <a id='forgettenPassword' href='initialisation.html' alt='réinitialisation du mot de passe'>Mot de passe oublié ?</a>
                            </fieldset>
                        </form>
                        <img id='userButton' src='./Icones/user.png' title='Connexion' alt='Logo utilisateur'>
                    </nav>
                    <header>
                        <div id='logo'>
                            <h1>Ver'ify Compost</h1>
                            <a href='index.html' alt='Retour à la page d'accueil' >
                                <picture>
                                    <source srcset='./Images/logo-site.webp' type='image/webp' />
                                    <source srcset='./Images/logo-site.png' type='image/png' /> 
                                    <img  id='retourAccueil' src='./Images/logo-site.png' alt='logo du site permettant de retourner à l'accueil'>
                                </picture>
                            </a>
                        </div>
                    </header>
                    <div class='leftMenuDesktop'>
                        <a class='lienMenuDesktop' href='index.html' alt='accueil'>Accueil</a>
                        <a class='lienMenuDesktop' href='#calendarFonctionnality' alt='calendrier memo'>Calendrier</a>
                        <a class='lienMenuDesktop' href='adminWaste.php' alt='administration'>Déchet</a>
                        <a class='lienMenuDesktop' href='guide.html' alt='guide entretien'>Conseils & entretien</a>
                        <a class='lienMenuDesktop' href='liens.html' alt='liens ressources'>Liens & Ressources</a>
                        <a class='lienMenuDesktop' href='contact.html' alt='contact'> Contact</a>
                        <a class='lienMenuDesktop' id='deconnexionDesktop' href='connexionDesktop.html' alt='deconnexion'><img src='./Icones/off.png' alt='bouton deconnexion'>Connexion</a>
                    </div>";
            }
    }
