<?php

//creation class ViewAdminWaste
class ViewIdentificationUser
{
    //Nous n'aurons pas de constructeur dans cette classe car nous savons que c'est une phrase qui est attendu dans les attributs (string). Nous pouvons directement mettre une chaîne de caractère ici.
    private ?string $messageConnection = "";
    private ?string $messageInscription = "";

    //GETTER SETTER
    public function getMessageConnection(): ?string
    {
        return $this->messageConnection;
    }

    public function setMessageConnection(?string $messageConnection): ViewIdentificationUser
    {
        $this->messageConnection = $messageConnection;
        return $this;
    }
    public function getMessageInscription(): ?string
    {
        return $this->messageInscription;
    }

    public function setMessageInscription(?string $messageInscription): ViewIdentificationUser
    {
        $this->messageInscription = $messageInscription;
        return $this;
    }

    //METHOD 
    public function displayView(): string
    {
        return
            "<main>
                <section class='identificationAdmin'>
                    <div class='lineMax'></div>
                    <div class='lineMin'></div>
                        <h2>Bienvenue lombric-addict·e !</h2>
                    <div class='lineMin'></div>
                    <div class='lineMax'></div>

                    <form method='post' action='index.php' id='connectionAdmin'>
                        <h3>Déja inscrit ? Connectez-vous !</h3>
                        <fieldset>
                            <legend>formulaire de connexion
                                <picture>
                                    <source srcset='./Images/trois-vers.webp' type='image/webp' />
                                    <source srcset='./Images/trois-vers.png' type='image/png' /> 
                                    <img src='./Images/trois-vers.png' alt='vers sortant d'un compost'/>
                                </picture>
                            </legend>
                                <label for='identifiantConnectionAdmin'>Votre identifiant *</label>
                                <input type='text' name='loginConnection' placeholder='5 caractères min dont 4 lettres' minlength='2' maxlength='25' id='identifiantConnectionAdmin' required autocomplete='on'>
                                <div id='identifiantErrorMessageConnectionAdmin'></div>

                                <label for='passwordConnectionAdmin'>Votre mot de passe *</label>
                                <input type='password' name='passwordConnection' placeholder='8 caractères min dont 1 majuscule, 1 minuscule et 1 chiffre' id='passwordConnectionAdmin' class='password' minlength='8' maxlength='30' autocomplete='off' required />
                                <div id='passwordErrorMessageConnectionAdmin'></div>
                            <button id='submitButtonConnectionAdmin' class='submitButton' type='submit' name='submitConnectUser' disabled>Connexion</button>
                            <p class='message'>{$this->getMessageConnection()}</p>
                            <a id='forgottenPasswordConnectionAdmin' href='initialisation.html' alt='réinitialisation du mot de passe'>Mot de passe oublié ?</a>
                        </fieldset>
                    </form>

                    <form method='post' action='index.php' id='inscriptionAdmin'>
                        <h3>Sinon, inscrivez-vous !</h3>
                        <fieldset>
                            <legend>formulaire d'inscription
                                <picture>
                                    <source srcset='./Images/trois-vers.webp' type='image/webp' />
                                    <source srcset='./Images/trois-vers.png' type='image/png' /> 
                                    <img src='./Images/trois-vers.png' alt='vers sortant d'un compost'/>
                                </picture>
                            </legend>

                                <label for='loginUser'>Votre identifiant *</label>
                                <input type='text' name='loginUser' placeholder='5 caractères min dont 4 lettres' minlength='5' maxlength='25' id='loginUser' autocomplete='no' required />
                                <div id='loginUserErrorMessage'></div>

                                <label for='mailInscription'>Votre adresse mail *</label>
                                <input type='mail' name='mailInscription' placeholder='exemple@mail.com' id='mailInscription' class='password' minlength='8' maxlength='30' autocomplete='no' required />
                                <div id='mailErrorMessage'></div>
                                
                                <label for='passwordInscription'>Votre mot de passe *</label>
                                <input type='password' name='passwordInscription' placeholder='8 caractères min dont 1 majuscule, 1 minuscule et 1 chiffre' id='passwordInscription' class='password' minlength='8' maxlength='30' autocomplete='no' required />
                                <div id='passwordErrorMessage1'></div>
                                
                                <label for='passwordInscription2'>Confirmer votre mot de passe *</label>
                                <input type='password' name='passwordInscription2' placeholder='Entrer à nouveau ce mot de passe' id='passwordInscription2' class='password2' autocomplete='no' required/>
                                <div id='passwordErrorMessage2'></div>
                                
                            <div class='checkboxContainer'>
                                <input type='checkbox' id='checkboxInscription' class='checkbox'/>
                                <label for='checkboxInscription'>Afficher les mots de passe</label>
                            </div>
                            <p class='message'>{$this->getMessageInscription()}</p>
                            <button id='submitButtonInscription' class='submitButton' type='submit' name='submitAddUser' disabled>Inscription</button>
                        </fieldset>
                    </form>
                </section>
                    
            </main>";

    }
}