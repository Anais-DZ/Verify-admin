// Validation formulaire de connexion

const identifiantConnection = document.querySelector('#identifiantConnectionAdmin'); 
const passwordConnection = document.querySelector('#passwordConnectionAdmin');
const identifiantConnectionError = document.querySelector('#identifiantErrorMessageConnectionAdmin');
const passwordConnectionError = document.querySelector('#passwordErrorMessageConnectionAdmin');
const submitButtonConnection = document.querySelector('#submitButtonConnectionAdmin');

submitButtonConnection.disabled = true;

function formConnectionValid() {
    const identifiantConnectionValue = identifiantConnection.value;
    const regexIdentifiantConnection = /^(?=(.*[A-Za-z]){4,}).{5,25}$/;

    const identifiantConnectionValid = regexIdentifiantConnection.test(identifiantConnectionValue);

    const passwordConnectionValue = passwordConnection.value;
    const regexPasswordConnection = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,30}$/;

    const passwordConnectionValid = regexPasswordConnection.test(passwordConnectionValue);


    if (identifiantConnectionValue.length > 0 && !identifiantConnectionValid) {
        identifiantConnectionError.innerText = "L'identifiant doit contenir au moins 5 caractères dont 4 lettres.";
    } else {
        identifiantConnectionError.innerText = '';
    }

    if (passwordConnectionValue.length > 0 && !passwordConnectionValid) {
        passwordConnectionError.innerText = 'Le mot de passe doit contenir au moins 8 caractères dont 1 chiffre, 1 lettre majuscule, 1 lettre minuscule.';
    } else {
        passwordConnectionError.innerText = '';
    }

    // Activation du bouton
    if (identifiantConnectionValid && passwordConnectionValid) {
        submitButtonConnection.disabled = false;
    } else {
        submitButtonConnection.disabled = true; 
    };

    // submitButtonConnection.disabled = !(identifiantConnectionValid && passwordConnectionValid) //! a retrevailler probleme
}
identifiantConnection.addEventListener('keyup', formConnectionValid);
passwordConnection.addEventListener('keyup', formConnectionValid);





// Récupération des éléments du DOM nécessaire pour les fonctions
const identifiantInscription = document.querySelector('#loginUser')
const errorIdentifiantInscriptionMessage = document.querySelector('#loginUserErrorMessage');

const mailInscription = document.querySelector('#mailInscription');
const mailErrorMessage = document.querySelector('#mailErrorMessage');

const passwordInscription = document.querySelector('#passwordInscription');
const errorInscriptionMessage1 = document.querySelector('#passwordErrorMessage1');

const passwordInscription2 = document.querySelector('#passwordInscription2');
const errorInscriptionMessage2 = document.querySelector('#passwordErrorMessage2');

const submitButtonInscription = document.querySelector('#submitButtonInscription');
const checkboxInscription = document.querySelector('#checkboxInscription');



// Fonction pour valider le formulaire d'inscription
function formInscriptionValid() {   

    // Validation de l'identifiant
    const identifiantInscriptionValue = identifiantInscription.value;
    const regexIdentifiantInscription = /^(?=(.*[A-Za-z]){4,}).{5,25}$/; 

    // signifie que l'identifiant doit être composé d'au moins 4 lettre avec un minimum de 5 caractères et 25 max
    // "test" permet de vérifier si identifiantValue (ou une chaîne de caractère en générale) correspond au régex. Ici, le régex correspond à identifiantValue.
    const identifiantInscriptionValid = regexIdentifiantInscription.test(identifiantInscriptionValue); 

    
    if (identifiantInscriptionValue.length > 0 && !identifiantInscriptionValid) {
            // pour que le message n'apparaissent pas au moment où l'on rentre l'indentifiant, la longueur du mot de passe de passe doit être plus grande que 0. S'il est plus grand, le message d'erreur apparaît à ce moment-là et pas avant
        errorIdentifiantInscriptionMessage.innerText = "L'identifiant doit contenir au moins 5 caractères dont 4 lettres."; // sinon message d'erreur
    } else {
        errorIdentifiantInscriptionMessage.innerText = ''; //Pas de message d'erreur  
    };

    // Validation du mail
    const mailInscriptionValue = mailInscription.value;
    const regexMailInscription = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mailInscriptionValid = regexMailInscription.test(mailInscriptionValue);

    if (mailInscriptionValue.length > 0 && !mailInscriptionValid) {
        mailErrorMessage.innerText = 'Adresse email invalide.';
    } else {
        mailErrorMessage.innerText = '';
    }
    
    // Validation du mot de passe principal (password)
    const passwordInscriptionValue = passwordInscription.value; 
    const regexPasswordInscription = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,30}$/; 
    // signifie que le mot de passe doit être composé de lettres majuscules et minuscule et de chiffres avec un minimum de 8 caractères et 30 max
    const passwordInscriptionValid = regexPasswordInscription.test(passwordInscriptionValue);

    if (passwordInscriptionValue.length > 0 && !passwordInscriptionValid) {  
        errorInscriptionMessage1.innerText = 'Le mot de passe doit contenir au moins 8 caractères dont 1 chiffre, 1 lettre majuscule, 1 lettre minuscule.';
    } else {
        errorInscriptionMessage1.innerText = ''; // Pas de message d'erreur
    };

    // Validation de la correspondance du mot de passe de confirmation (password2)
    const passwordInscriptionValue2 = passwordInscription2.value;
    // Pas de regex pour le password2 puisqu'il sera juste comparé au password
    const password2InscriptionValid = passwordInscriptionValue == passwordInscriptionValue2;

    if (passwordInscriptionValue2.length > 0 && !password2InscriptionValid) { 
        // Si le premier mot de passe ne correspond pas au second mot de passe, le message d'erreur apparaît
        errorInscriptionMessage2.innerText = 'Les mots de passe ne correspondent pas.';
        
    } else {
        errorInscriptionMessage2.innerText = ''; // Pas de message d'erreur
    };

    // Activation du bouton
    if (identifiantInscriptionValid && passwordInscriptionValid && password2InscriptionValid && mailInscriptionValid) {
        submitButtonInscription.disabled = false;
    } else {
        submitButtonInscription.disabled = true;
    }
    
};
// Evénements pour la validation du formulaire
identifiantInscription.addEventListener('keyup', formInscriptionValid);
mailInscription.addEventListener('keyup', formInscriptionValid);
passwordInscription.addEventListener('keyup', formInscriptionValid);
passwordInscription2.addEventListener('keyup', formInscriptionValid);


// Fonction pour afficher les mots de passe
function  passwordVisible() {
    if (!checkboxInscription.checked) { // Si la checkbox n'est pas cochée, le mot de passe ne sera pas visible
        passwordInscription.type = 'password';
        passwordInscription2.type = 'password';
        
    } else { // S'il est coché, le type est modifié en texte et permet à la chaîne de caractères d'être visible
        passwordInscription.type = 'text';
        passwordInscription2.type = 'text';    
    }
};
checkboxInscription.addEventListener('click', passwordVisible);




// Les placeholder

//! Si tu veux te servir de cette fonction durant l'oral, n'oublie pas d'aller commenter celle dans le js commun, ça t'évitera un gros bug et du stress. Signé : toi-même ;)
// Sélectionne tous les inputs avec un attribut placeholder
// const inputs = document.querySelectorAll("input[placeholder]");

// inputs.forEach((input) => { // A chaque input trouvé dans le code, la fonction suivante lui sera appliquée

//     const initialPlaceholder = input.placeholder;

//     input.addEventListener("focus", () => {
//         input.placeholder = ""; // le focus "supprime" le plaholder
//     });

//     input.addEventListener("blur", () => { // blur = quand on clique en dehors de l'input
//         input.placeholder = initialPlaceholder; //initialPlaceholder permet de "stocker" le placeholder. Par exemple si le placeholder est "mot de passe", initialPlaceholder sera "mot de passe"
//     });
// });