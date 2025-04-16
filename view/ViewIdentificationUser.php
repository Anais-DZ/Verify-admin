<?php

    //creation class ViewAdminWaste
    class ViewIdentificationUser {
        //Nous n'aurons pas de constructeur dans cette classe car nous savons que c'est une phrase qui est attendu dans les attributs (string). Nous pouvons directement mettre une chaîne de caractère ici.
        private ?string $messageConnexion = "";
        private ?string $messageInscription = "";

        //GETTER SETTER
        public function getMessageConnexion(): ?string {
            return $this->messageConnexion;
        }

        public function setMessageConnexion(?string $messageConnexion): ViewIdentificationUser {
                $this->messageConnexion = $messageConnexion;
                return $this;
        }
        public function getMessageInscription(): ?string {
                return $this->messageInscription;
        }

        public function setMessageInscription(?string $messageInscription): ViewIdentificationUser {
            $this->messageInscription = $messageInscription;
            return $this;
        }

        //METHOD 
        public function displayView(): string {
            return 
                "<main>
                    <div class='inscription'>
                        <div class='bandeHorizontale1'></div>
                        <div class='bandeHorizontale2'></div>
                        <h2>Bienvenue lombric-addict·e ou simple curieux·e !</h2>
                        <p class='constructionButton'>(Le site étant actuellement en développement, il est possible de remplir le formulaire mais pas de s'inscrire)</p>

                    <section class='formulaireDesktop'>
                        <form method='post' action='identificationUser.php' id='formConnexionDesktop'>
                            <h3>Déja inscrit ? Connectez-vous !</h3>
                            <fieldset>
                                <legend>formulaire de connexion
                                    <picture>
                                        <source srcset='./Images/trois-vers.webp' type='image/webp' />
                                        <source srcset='./Images/trois-vers.png' type='image/png' /> 
                                        <img src='./Images/trois-vers.png' alt='vers sortant d'un compost'/>
                                    </picture>
                                </legend>
                                <div>
                                    <label for='identifiantConnexionDesktop'>Votre identifiant *</label>
                                    <input type='text' name='loginConnexion' placeholder='5 caractères min dont 4 lettres' minlength='2' maxlength='25' id='identifiantConnexionDesktop' required autocomplete='on'>
                                    <div id='identifiantErrorMessageConnexionDesktop'></div>
                                </div>
                                <div class='inscriptionContainer'>
                                    <label for='passwordConnexionDesktop'>Votre mot de passe *</label>
                                    <input type='password' name='passwordConnexion' placeholder='8 caractères min dont 1 majuscule, 1 minuscule et 1 chiffre' id='passwordConnexionDesktop' class='password' minlength='8' maxlength='30' autocomplete='off' required />
                                    <div id='passwordErrorMessage1ConnexionDesktop'></div>
                                </div>
                                <div class='checkboxContainer'>
                                    <input type='checkbox' id='checkboxConnexionDesktop' checked />
                                    <label for='checkboxConnexionDesktop'>Se souvenir de moi</label>
                                </div>
                                <button id='submitButtonConnexionDesktop' class='submitButton' type='submit' name='submitConnectUser' disabled>Connexion</button>
                                <p class='message'>{$this->getMessageConnexion()}</p>
                                <a id='forgettenPasswordConnexionDesktop' href='initialisation.html' alt='réinitialisation du mot de passe'>Mot de passe oublié ?</a>
                            </fieldset>
                        </form>

                        <p id='coordination'>ou</p>

                        <form method='post' action='identificationUser.php' id='inscription-form'>
                            <h3>Pas encore de compte ? Inscrivez-vous !</h3>
                            <fieldset>
                                <legend>formulaire d'inscription
                                    <picture>
                                        <source srcset='./Images/trois-vers.webp' type='image/webp' />
                                        <source srcset='./Images/trois-vers.png' type='image/png' /> 
                                        <img src='./Images/trois-vers.png' alt='vers sortant d'un compost'/>
                                    </picture>
                                </legend>
                                <div>
                                    <label for='loginUser'>Votre identifiant *</label>
                                    <input type='text' name='loginUser' placeholder='5 caractères min dont 4 lettres' minlength='5' maxlength='25' id='loginUser' autocomplete='on' required />
                                    <div id='loginUserErrorMessage'></div>
                                </div>
                                <div class='inscriptionContainer'>
                                    <label for='mailInscription'>Votre adresse mail *</label>
                                    <input type='mail' name='mailInscription' placeholder='*******@****.***' id='mailInscription' class='password' minlength='8' maxlength='30' autocomplete='on' required />
                                    <div id='mailErrorMessage1'></div>
                                </div>
                                <div class='inscriptionContainer'>
                                    <label for='passwordInscription'>Votre mot de passe *</label>
                                    <input type='password' name='passwordInscription' placeholder='8 caractères min dont 1 majuscule, 1 minuscule et 1 chiffre' id='passwordInscription' class='password' minlength='8' maxlength='30' autocomplete='on' required />
                                    <div id='passwordErrorMessage1'></div>
                                </div>
                                <div class='inscriptionContainer'>
                                    <label for='passwordInscription2'>Confirmer votre mot de passe *</label>
                                    <input type='password' name='passwordInscription2' placeholder='Entrer à nouveau ce mot de passe' id='passwordInscription2' class='password2' autocomplete='on' required/>
                                    <div id='passwordErrorMessage2'></div>
                                </div>
                                <div class='checkboxContainer'>
                                    <input type='checkbox' id='checkboxInscription' class='checkbox'/>
                                    <label for='checkboxInscription'>Afficher les mots de passe</label>
                                </div>
                                <p class='message'>{$this->getMessageInscription()}</p>
                                <button id='submitButtonInscription' class='submitButton' type='submit' name='submitAddUser' disabled>Inscription</button>
                            </fieldset>
                        </form>
                    </section>
                        <div class='bandeHorizontale2'></div>
                        <div class='bandeHorizontale1'></div>
                    </div>
                </main>";

        }
    }