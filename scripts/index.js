                    // Foncions carrousel
document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carouselInner .slide");
    const prevButton = document.querySelector(".carouselControl.prev");
    const nextButton = document.querySelector(".carouselControl.next");
    const totalSlides = slides.length;

    let currentIndex = 0; // Index de la slide actuellement affichée

    // Fonction pour mettre à jour l'affichage des slides
    function updateSlides() {
        slides.forEach((slide, index) => {
            // Active ou désactive l'affichage des slides
            if (index == currentIndex) {
                slide.style.display = "block"; // Affiche la slide actuelle
            } else {
                slide.style.display = "none"; // Cache les autres slides
            }
        });
    }
    // Initialisation : afficher la première slide
    updateSlides();


    // Événement pour le bouton "Précédent"
    prevButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Retourne au dernier élément si on dépasse
        updateSlides();
    });

    // Événement pour le bouton "Suivant"
    nextButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % totalSlides; // Retourne au premier élément si on dépasse
        updateSlides();
    });
});



// Fonctions recherche des déchets

//la variable tabDechet stocke un tableau d'objets contenant les données récupérées depuis l'api
const tabDechet = [];

// Fonction recupererDechetsApi() pour récupérer les données de l'api et remplir le tableau dynamiquement
// async indique que la fonction va effectuer une requête et attendre la réponse avant de passer à la suite du code
const recupererDechetsApi = async ()=> {
    try {

        // utilisation de fetch() pour envoyer une requête à l'adresse url de l'api
        const response = await fetch('http://localhost/verify_compost_php/wasteAPI.php'); // adresse de mon api des déchets

        if (!response.ok) {
            //s'il n'y a pas de réponse de l'api, envoi d'un message d'erreur
            throw new Error('Erreur de récupération des données, pas de chance !');
        }
        
        //la réponse va pouvoir être transformée grâce à json() que l'on stocke dans la variable data
        const data = await response.json();

        //les données récupérées passent par forEach pour créer le tableau tabDechet
        data.forEach(dechet => {
            tabDechet.push({ //push() ajoute un élément à un tableau
                name_waste: dechet.name_waste,
                type_container: dechet.type_container
            });
        });
    // récupération du message d'erreur
    } catch (error) {
        console.error('Erreur lors de la récupération des données de l\'api', error);
    }
}
// appel de la fonction
recupererDechetsApi();


const input = document.getElementById('biodechet');
const suggestionsListeDechets = document.getElementById('suggestionsDechets');
const verifierButton = document.getElementById('boutonVerifier');
const resultatOverlay = document.getElementById('resultatOverlay');
const closeOverlayButton = document.getElementById('closeOverlay');


                        //Fonction pour la suggestion des déchets 

//Fonction pour afficher la liste de suggestions pendant que l'utilisateur tape son mot
function gestionInput() {
    const recherche = input.value; //déclaration de la variable "recherche" qui stocke ce qui est tapé dans l'input
    afficherSuggestions(recherche); //appel de la fonction
};
input.addEventListener('input', gestionInput);


// La fonction normaliserEcritureDechet() va permettre de normaliser les mots entrés par l'utilisateur et faciliter leur comparaison ensuite
function normaliserEcritureDechet(motEntre) {
    return motEntre // retourne la version normalisée
        .normalize('NFD') // Sépare les lettres des accents pour qu'on puisse les supprimer.
        .replace(/['’\s–—-]|[\u0300-\u036f]/g, '')
        // [\u0300-\u036f] Enlève les accents
        // ['’] Enlève les apostrophes
        // /\s/ Supprime tous les espaces
        // [-–—] Supprime les tirets
        .toLowerCase();  // Tout mettre en minuscule

        // - normalize('NFD') -> NFD (Normalization Form Decomposed) va permettre de normaliser une chaîne de caractère en décomposant les caractères spéciaux en caractères de base et accent séparé. Ex : "é" (U+00E9) devient "e" (U+0065) + "´" (U+0301). La chaîne de caractère sera rendue plus facile à comparer ensuite.

        // - replace(/[\u0300-\u036f]/g, '') : un regex est utilisé par replace() pour remplacer tous les caractères spéciaux de la du/des mots recherché(s) par une chaîne vide.

      
}


function afficherSuggestions(recherche) {
    suggestionsListeDechets.innerText = ''; // Réinitialise la liste pour qu'elle "suive" ce que rentre l'utilisateur.

    if (recherche) { // la liste s'affichera quand l'utilisateur commencera à taper sa recherche

        //! La recherche ne doit faire aucune différence entre les mots tapés sans accent et les mots qui ont un accent dans le tableau (ex: taper "epluchures" doit renvoyer "Épluchures") et enlever les apostrophes et les espaces pour que la liste de suggestions ne disparaisse pas après avoir tapé un espace entre deux mots.
        const normalisationDeLaRecherche = normaliserEcritureDechet(recherche); //appel de la fonction normaliserEcritureDechet() pour normaliser le mot recherché
            

        //! Normalisation de la recherche en supprimant les accents, les espaces, etc..., en remplaçant les majuscules par les minuscules et en la triant par ordre alphabétique
        const rechercheUtilisateur = tabDechet.filter(dechet => {
            // - filter() va permettre de filtrer les déchets pour ne garder que ceux qui correspondent à la recherche après la normalisation (tout ce qui suit dans la parenthèse).

            // Normalisation du nom du déchet sans accents, apostrophes, et espaces, etc... avec la fonction normaliserEcritureDechet()
            const nomDechetNormalise = normaliserEcritureDechet(dechet.name_waste);

            // Retourne le nom du déchet qui commence par les premières lettres tapées dans la recherche
            return nomDechetNormalise.startsWith(normalisationDeLaRecherche);

            // - startWith() permet d'afficher dans la liste, les déchet qui commencent par les lettres tapées par l'utilisateur après avoir enlevé les accents grâce à rechercheSansAccent en paramètre.

        }).sort((a, b) => {
            // une fois les déchets retournés, ils vont être affichés par ordre alphabétique
            return a.name_waste.localeCompare(b.name_waste);

            // - sort() permet de comparer deux éléments du tableau (ici les objets a et b) pour savoir lequel doit venir avant l'autre dans l'affichage de la liste.

            // - localeCompare() permet de trier un tableau sans tenir compte de la casse et des caractères spéciaux (ex: "chewing-gum" "Cheveux" seront comparés et mis par odre alphabétique dans la liste même si l'un deux a une majuscule dans le tableau)
        });
        
        

        if (rechercheUtilisateur.length > 0) { //vérifie qu'au moins un déchet est trouvé sinon affichera une liste vide
            suggestionsListeDechets.style.display = 'block'; // La liste s'affiche si une lettre minimum est entrée sinon reste invisible, même durant le focus

            rechercheUtilisateur.forEach(dechet => { //forEach() permet de parcourir le tableau et créera une ligne (li) dans la liste du html (ul) à chaque élément trouvé (si je cherche "oeuf", foreach va rechercher l'élément "oeuf" dans le tableau et renvoyer cet élément dans une ligne). La liste n'existant pas dans le Dom, elle est produite en JS. Sans ça, la liste restera vide)
                const ligneSuggestion = document.createElement('li'); //déclaration de la variable qui contiendra cette ligne créée
                ligneSuggestion.innerText = dechet.name_waste; //ajoute le texte du nom du déchet dans <li> et non le nom + le type
                suggestionsListeDechets.appendChild(ligneSuggestion); //ajoute <li> créé à la liste

                //va permettre de remplir l'input avec le déchet suggéré lorsque l'utilisateur va cliquer dessus
                ligneSuggestion.addEventListener('click', () => {
                    input.value = ligneSuggestion.innerText; //la valeur de l'input sera le nom du déchet cherché
                    suggestionsListeDechets.style.display = 'none'; // et la liste "disparaît" après avoir cliqué sur le déchet

                    // quand l'utilisateur clique sur le déchet dans la liste, cela appelle la fonction resultatRecherche qui permet de rechercher le déchet dans tadDechet et afficher l'overlay. Permet à l'utilisateur d'éviter des click
                    resultatRecherche(input.value);
                });
            });

        } else {
            suggestionsListeDechets.style.display = 'none'; //la liste de suggestion n'apparaît pas si aucun déchet n'est trouvé
        }

    } else {
        suggestionsListeDechets.style.display = 'none'; //la liste n'apparaît pas si aucun texte n'est tapé ou si l'utilisateur efface sa recherche
    }
}

// Fonction pour fermer la liste des suggestions si l'utilisateur clique ailleurs que sur la liste
function fermerListe(event) {
    if (!suggestionsListeDechets.contains(event.target) && !input.contains(event.target)) { //la liste sera fermée si l'utilisateur clique ailleurs que sur la liste et sur l'unput
        suggestionsListeDechets.style.display = 'none';
    }
}
document.addEventListener('click', fermerListe);


// Fonction pour afficher l'overlay de la recherche et qui servira pour la fonction resultatRecherche(dechetRecherche)
function afficherOverlay(titre, description, reponse, imageComposteur) {
    const overlayTitre = document.getElementById('overlayTitre');
    const overlayDescription = document.getElementById('overlayDescription');
    const overlayReponse = document.getElementById('overlayReponse');
    const overlayImage = document.getElementById('overlayImage');

    // Permet d'écrire dans l'overlay (l'overlay est vide dans le html) et modifier le texte selon le déchet trouvé:
    overlayTitre.innerText = titre; // permet la mise à jour du titre
    overlayDescription.innerText = description; // permet la mise à jour de la description
    overlayReponse.innerText = reponse; // permet la mise à jour de la réponse
    overlayImage.src = `./Images/${imageComposteur}`; // permet la mise à jour de l'image

    // Affiche l'intérieur de l'overlay en colonne
    //resultatOverlay est la div du dom qui contient l'overlay et qui n'apparaît pas physiquement dans le html de l'index
    resultatOverlay.style.display = 'flex';
    resultatOverlay.style.flexDirection = 'column';
};


// Fonction qui permet de rechercher le déchet dans tabDechet et d'afficher l'overlay permettant à l'utilisateur de savoir où jeter le biodéchet.
function resultatRecherche(dechetRecherche) {

    const dechetEntre = normaliserEcritureDechet(dechetRecherche); // appel de la fonction normaliserEcritureDechet() pour normaliser le déchet recherché. Cela permettra qu'en cas d'oublie d'espace par exemple, le bon résultat s'affichera (ex: si l'utilisateur tape "cartonsans encre", le résultat renverra "carton sans encre" et affichera le bon overlay et non l'overlay d'un déchet inconnu )

    
    // find() permet de rechercher le déchet dans tabDechet qui correspond exactement au mot stocké dans la variable ecritureDechet et va le stocker dans la variable dechetTrouve
    const dechetTrouve = tabDechet.find(dechet => {

        // Recherche du déchet dans tabDechet avec normalisation du nom du déchet
        const nomDechetNormalise = normaliserEcritureDechet(dechet.name_waste); // appel de la fonction normaliserEcritureDechet() pour normaliser dechet.name_waste 

        return nomDechetNormalise === dechetEntre; // retourne le nom du déchet trouvé dans tabDechet s'il est strictement identique au déchet entré par l'utilisateur
    });

    if (dechetTrouve) { //Une fois le nom du déchet normalisé, vérification de l'existence du déchet dans tabDechet et s'il existe, nous passons aux conditionx suivantes

        const typeContainer = dechetTrouve.type_container;

        if (typeContainer.includes("Composteur et lombricomposteur")) {
            afficherOverlay( //appel de la fonction qui va afficher l'overlay
                dechetTrouve.name_waste, // Affichage du nom exact et pas le mot tapé par l'utilisateur (ex: si l'utilisateur tape "cartonsans encre", le nom du déchet qui sera réeelement affiché sur l'overlay sera "carton sans encre")
                "(en petits morceaux et/ou humidifiés pour nos amis les vers)",
                "✅ Convient au composteur et lombricomposteur",
                "compost-coeur.webp" // Image pour les deux composteurs
            );
        } else if (typeContainer.includes("Composteur")) {
            afficherOverlay(
                dechetTrouve.name_waste,
                "Ne convient pas au lombricomposteur",
                "⚠️ Convient uniquement au composteur",
                "compost-okay.webp" // Image pour composteur uniquement
            );
        } else {
            afficherOverlay(
                dechetTrouve.name_waste,
                "Ce déchet doit être jeté avec les ordures ménagères ou au recyclage s'il se recycle",
                "❌ Ne convient ni au composteur, ni au lombricomposteur",
                "compost-triste.webp" // Image pour non compostable
            );
        }
    } else {
        afficherOverlay(
            dechetRecherche, // Affichage du mot exacte tapé par l'utilisateur car il n'existe pas dans le tableau
            "❓",
            "Ce déchet m'est inconnu et va me demander quelques recherches plus approfondies. En attendant, le mieux est de le jeter dans la poubelle ordinaire ou au recyclage s'il se recycle.",
            "ver-perplexe.webp" // Image pour déchet inconnu
        );
    }
}


// Fonction pour valider la recherche avec la touche "Entrée" du clavier ou avec le bouton "Verifier"
function VerifierDechet(event) {
    // Vérifie si l'utilisateur a appuyé sur "Entrée" ou a cliqué sur le bouton "Verifier"
    if (event.key === 'Enter' || event.type === 'click') {  
        event.preventDefault(); //empeche la page de remonter
        
        const inputValue = input.value;

        if (inputValue === "") {
            return; // Si l'input est vide, cliquer sur "Vérifier" ne fait pas apparaître l'overlay
        } else {
            resultatRecherche(inputValue);  // sinon appel de la fonction de recherche
        }
    }
}
// Écouteur d'événements pour la touche "Enter" dans l'input
input.addEventListener('keydown', VerifierDechet);

// Écouteur d'événements pour le clic sur le bouton de recherche
if (verifierButton) {
    verifierButton.addEventListener('click', VerifierDechet); 
}


// Fonction pour réinitialiser l'input quand il reçoit le focus
function resetInput() {
    input.value = ''; // Vide l'input de son texte précédent
    suggestionsListeDechets.style.display = ''; // Cache la liste des suggestions
}
input.addEventListener('focus', resetInput);


// Événement pour fermer l'overlay avec la croix
closeOverlayButton.addEventListener('click', (event) => {
    event.preventDefault(); // Empêche la page de remonter après la fermeture avec la croix
    resultatOverlay.style.display = 'none'; // Cache l'overlay
    
});

// Événement pour fermer l'overlay avec un click en dehors de l'overlay
resultatOverlay.addEventListener('click', (event) => {
    if (event.target == resultatOverlay) {
        resultatOverlay.style.display = 'none'; // Cache l'overlay
    }
});





                    //Fonctions mémo 
const noteList = document.querySelector('#noteList');
const noteInput = document.querySelector('#noteInput');
const boutonAjoutNote = document.querySelector('#boutonAjoutNote');

// les notes sont récupérées dans le localStorage
noteList.innerHTML= localStorage.getItem('listItems') || '';


// Ajouter un nouvel élément
function ecrireMemo() {

    const item = noteInput.value;

    if (item) {
        const listItem = document.createElement('li');
        listItem.innerHTML = DOMPurify.sanitize (`
            <span class="item">${item}</span>
            <button class="supprimer">❌</button>
        `);
        noteList.appendChild(listItem);

        // Mettre à jour le localStorage
        localStorage.setItem('listItems', noteList.innerHTML);

        // Réinitialiser le champ d'entrée
        noteInput.value = '';
    };
};
boutonAjoutNote.addEventListener('click', ecrireMemo);

// Fonction pour ajouter une note à la liste //! A tester avec le code html pour éviter le innerHtml
// function ecrireMemo() {
//     const item = noteInput.value.trim(); // Supprimer les espaces inutiles
//     if (item) {
//         // Créer un nouvel élément li
//         const listItem = document.createElement('li');
//         listItem.classList.add('noteItem');
        
//         // Ajouter le texte de la note
//         const span = document.createElement('span');
//         span.classList.add('item');
//         span.innerText = item;
//         listItem.appendChild(span);
        
//         // Ajouter le bouton "supprimer"
//         const deleteButton = document.createElement('button');
//         deleteButton.classList.add('supprimer');
//         deleteButton.innerText = '❌';
//         deleteButton.addEventListener('click', function () {
//             // Supprimer l'élément li
//             listItem.remove();
//             // Mettre à jour le localStorage
//             localStorage.setItem('listItems', noteList.innerHTML);
//         });
//         listItem.appendChild(deleteButton);

//         // Ajouter l'élément à la liste
//         noteList.appendChild(listItem);

//         // Mettre à jour le localStorage
//         localStorage.setItem('listItems', noteList.innerHTML);

//         // Réinitialiser le champ d'entrée
//         noteInput.value = '';
//     }
// }

// // Ajouter un écouteur d'événement au bouton
// boutonAjoutNote.addEventListener('click', ecrireMemo);

// // Gérer le rechargement de la page (les boutons "supprimer" doivent fonctionner après rechargement)
// document.querySelectorAll('.supprimer').forEach(button => {
//     button.addEventListener('click', function () {
//         button.parentElement.remove();
//         localStorage.setItem('listItems', noteList.innerHTML);
//     });
// });


// Gérer la suppression d'un élément
noteList.addEventListener('click', (event) => {
    if (event.target.classList.contains('supprimer')) {
        const listItem = event.target.closest('li');
        
        if (listItem) {
            listItem.remove();

            // enregistrement dans le localstorage
            localStorage.setItem('listItems', noteList.innerHTML);
        }
    }
    // Rayer une note
    if (event.target.classList.contains('item')) {
        event.target.classList.toggle('itemRayee');
        
        // enregistrement dans le localstorage
        localStorage.setItem('listItems', noteList.innerHTML);
    }
});
    


  
            //fonction avec prise de note dans le calendrier 
//!les notes ne restent pas, en attente de php pour connexion utilisateur


// Sélection des éléments DOM
const moisAnnee = document.querySelector('#moisAnnee');
const calendarDaysContainer = document.querySelector('#calendarDaysContainer');
const buttonPrev = document.querySelector('#calendarButtonPrev');
const buttonNext = document.querySelector('#calendarButtonNext');

// Initialisation des dates
const jour = new Date();
let moisActuel = jour.getMonth();
let anneeActuel = jour.getFullYear();

// Noms des mois
const mois = [
    "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
    "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
];

// Stockage des notes
const notes = {};

// Fonction pour générer le calendrier
function creerCalendrier(month, year) {
    // Efface le contenu précédent
    calendarDaysContainer.innerText = '';

    // Calculs des dates
    const premierJour = new Date(year, month, 1).getDay();
    const joursDansLeMois = new Date(year, month + 1, 0).getDate();
    const joursDuMoisPrecedent = new Date(year, month, 0).getDate();
    const startDay = premierJour === 0 ? 6 : premierJour - 1;

    // Afficher le mois et l'année
    moisAnnee.innerText = `${mois[month]} ${year}`;

    let date = 1; // Premier jour du mois actuel
    let jourDuMoisSuivant = 1; // Premier jour du mois suivant

    // Génération des lignes du calendrier
    for (let i = 0; i < 6; i++) { // Maximum 6 semaines
        const ligne = document.createElement('tr');

        for (let j = 0; j < 7; j++) {
            const cellule = document.createElement('td');

            if (i === 0 && j < startDay) {
                // Jours du mois précédent
                const prevDate = joursDuMoisPrecedent - startDay + j + 1;
                cellule.innerText = prevDate;
                cellule.classList.add('moisSuivantPrecedent');
            } else if (date > joursDansLeMois) {
                // Jours du mois suivant
                cellule.innerText = jourDuMoisSuivant++;
                cellule.classList.add('moisSuivantPrecedent');
            } else {
                // Jours du mois actuel
                const dateDuJour = `${date}/0${month + 1}/${year}`;
                cellule.innerText = date;

                // Vérifier les notes et ajouter une icône
                // const noteExistante = localStorage.getItem(dateDuJour);
                // if (noteExistante) {
                //     const marquage = document.createElement('span');
                //     marquage.innerText = '📌';
                //     marquage.classList.add('noteIcone');
                //     cellule.appendChild(marquage);
                    
                // }

                // Mettre en surbrillance le jour actuel
                if (
                    date === jour.getDate() &&
                    month === jour.getMonth() &&
                    year === jour.getFullYear()
                ) {
                    cellule.classList.add('jour');
                }

                // Ajouter un événement de clic pour les notes
                // cellule.addEventListener('click', () => ajoutNote(dateDuJour, cellule));

                date++;
            }
            ligne.appendChild(cellule);
        }
        calendarDaysContainer.appendChild(ligne);
    }
}

document.addEventListener("DOMContentLoaded", function () { //! à commenter si tu veux remettre la boite de dialogue
    const overlayTache = document.getElementById("overlayListeTaches");
    const tacheDate = document.getElementById("tacheDate");
    const closeOverlayBtn = document.getElementById("closeOverlayBtn");

    function openOverlay(date) {
        tacheDate.innerText = `Tâches pour le ${date}`;
        overlayTache.style.display = "flex";
    }

    function closeOverlay() {
        overlayTache.style.display = "none";
    }

    closeOverlayBtn.addEventListener("click", closeOverlay);

    // Exemple d'intégration avec le calendrier
    document.querySelectorAll(".calendar td").forEach(cell => {
        cell.addEventListener("click", function () {
            const dateSelectionnee = this.innerText + "/" + "0"+(new Date().getMonth() + 1) + "/" + new Date().getFullYear();
            openOverlay(dateSelectionnee);
        });
    });
});

// // Fonction pour ajouter et enregistrer une note
// function ajoutNote(date, cellule) { //! à décommenter si tu veux remettre la boite de dialogue
//     // les notes sont récupérées du localstorage
//     const note = prompt(`Vous pouvez noter ce que vous avez fait ou aller faire pour entretenir votre composteur (ex : récupérer le compost, ajouter des déchets humide, etc...), ce jour-là, le ${date}:`, localStorage.getItem(date) || '');
//     if (note) {
//         // la note sera stockée dans le local storage
//         localStorage.setItem(date, note);

//         // Si une note est entrée, un marquage est créé
//         if (!cellule.querySelector('.noteIcone')) {
//             const marquage = document.createElement('span');
//             marquage.innerText = '📌';
//             marquage.classList.add('noteIcone');
//             cellule.appendChild(marquage);
//         }
//     } else {
//         // si pas de note, le marquage est supprimé du local storage
//         localStorage.removeItem(date);
//     }
// }

// Navigation entre les mois
buttonPrev.addEventListener('click', () => {
    moisActuel--;
    if (moisActuel < 0) {
        moisActuel = 11;
        anneeActuel--;
    }
    creerCalendrier(moisActuel, anneeActuel);
});

buttonNext.addEventListener('click', () => {
    moisActuel++;
    if (moisActuel > 11) {
        moisActuel = 0;
        anneeActuel++;
    }
    creerCalendrier(moisActuel, anneeActuel);
});

// Initialiser le calendrier
creerCalendrier(moisActuel, anneeActuel);