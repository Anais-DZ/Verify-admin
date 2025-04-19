<?php

// Démarrage de la session
session_start();

//INCLUDES
include './env.php';
include './utils/utils.php';
include './model/modelUser.php';
include './view/viewHeader.php';
include './view/viewFooter.php';
include './view/viewIdentificationUser.php';
include './controller/genericController.php';

//Création de la classe IdentificationController
class IdentificationUserController extends GenericController
{

    //ATTRIBUT
    private ?ViewIdentificationUser $viewIdentificationUser;
    private ?ModelUser $modelUser;


    //CONSTRUCTOR
    public function __construct(?ViewIdentificationUser $viewIdentificationUser, ?ModelUser $modelUser)
    {
        //Paramètres hérités du parent GenericController
        $this->setHeader(new ViewHeader());
        $this->setFooter(new ViewFooter());
        $this->viewIdentificationUser = $viewIdentificationUser;
        $this->modelUser = $modelUser;
    }


    //GETTER ET SETTER
    public function getViewIdentificationUser(): ?ViewIdentificationUser
    {
        return $this->viewIdentificationUser;
    }

    public function setViewIdentificationUser(?ViewIdentificationUser $viewIdentificationUser): IdentificationUserController
    {
        $this->viewIdentificationUser = $viewIdentificationUser;
        return $this;
    }

    public function getModelUser(): ?ModelUser
    {
        return $this->modelUser;
    }

    public function setModelUser(?ModelUser $modelUser): IdentificationUserController
    {
        $this->modelUser = $modelUser;
        return $this;
    }

    //METHOD

    //Inscrire un utilisateur avec la fonction registerUser()
    public function registerUser(): string
    {

        //1_ Vérifier la réception du formulaire
        if (isset($_POST['submitAddUser'])) {

            //2_ Vérifier les champs vides
            if (empty($_POST['loginUser']) || empty($_POST['mailInscription']) || empty($_POST['passwordInscription']) || empty($_POST['passwordInscription2'])) {
                return 'Tous les champs ne sont pas remplis';
            }

            //3_ Vérifier le format de l'email
            if (!filter_var($_POST["mailInscription"], FILTER_VALIDATE_EMAIL)) {
                return "L'email n'est pas au bon format.";
            }

            if ($_POST['passwordInscription'] !== $_POST['passwordInscription2']) {
                return "Les mots de passe ne correspondent pas.";
            }

            //4_ Nettoyer les données
            $loginUser = clean($_POST['loginUser']);
            $mailUser = clean($_POST['mailInscription']);
            $passwordUser = clean($_POST['passwordInscription']);

            //5_ hasher le mot de passe
            $passwordUser = password_hash($passwordUser, PASSWORD_BCRYPT);

            //6_ Vérifier que le déchet n'existe pas déjà en BDD
            //6.1_ Donner le nom du déchet au Model
            $this->getModelUser()->setMailUser($mailUser);

            //6.2_ Demander au Model d'utiliser getByMailUser()
            $data = $this->getModelUser()->getByMailUser();

            //6.3_ Vérifier si les données sont vides ou non
            if (!empty($data)) {
                return 'Cet email est déjà utilisé par un utilisateur.';
            }

            //7_ Enregistrer le déchet en BDD
            //7.1_ Donner le mail et le password au ModelUser (l'email a déjà eté "setté" plus haut au 6.1)
            $this->getModelUser()->setLoginUser($loginUser)->setPasswordUser($passwordUser);


            //7.2_ Demander au model d'utiliser addUser()
            $data = $this->getModelUser()->addUser();

            //8_ Retourne un message de confirmation
            return $data;
        }
        return '';
    }

    //Se connecter avec la fonction connectUser()
    public function connectUser(): string
    {
        //1_ Vérifier si le formulaire est submit
        if (isset($_POST["submitConnectUser"])) {

            //2_ Vérifier que les données ne soient pas vides
            if (empty($_POST["loginConnection"]) || empty($_POST["passwordConnection"])) {
                return "Veuillez remplir tous les champs.";
            }

            //4_ Nettoyer les données avec la fonction clean()
            $loginConnection = clean($_POST["loginConnection"]);
            $passwordConnection = clean($_POST["passwordConnection"]);

            //5_ Récupération des données de l'utilisateur en BDD
            //5.1_ donner au modelUser, le login à aller chercher en BDD
            $this->getModelUser()->setLoginUser($loginConnection);

            //5.2_demander au modelUser d'utiliser getByLoginUser() pour aller chercher les données et je les conserve dans une variable $data
            $data = $this->getModelUser()->getByLoginUser();

            //5.3_ Vérifier si les données sont vides ou non
            if (empty($data)) {
                return "Email et/ou mot de passe incorrect(s).";
            }

            //6_ Comparer les mots de passe
            //pas passwordConnection ici car on cherche le password de l'inscription
            if (!password_verify($passwordConnection, $data[0]["password_user"])) {
                return "Email et/ou mot de passe incorrect(s).";
            }


            //7_ J'enregistre l'id, le login et l'email dans la super-globale $_SESSION
            $_SESSION["id_user"] = $data[0]["id_user"];
            $_SESSION["login_user"] = $data[0]["login_user"];
            $_SESSION["mail_user"] = $data[0]["mail_user"];
            $_SESSION["id_role"] = $data[0]["id_role"];

            //8_ Redirection vers la page adminWaste
            if ($_SESSION['id_role'] == 2) {
                header("Location: adminWaste.php");
                exit();
            } else {
                echo "<script>alert('Accès refusé. Vous n\'avez pas les droits nécessaires.');</script>";
            }
        }

        return "";
    }


    public function render(): void
    {

        //Déclaration de la variable d'affichage
        $script = "<script src='./scripts/identificationUser.js'></script>
        <script src='./scripts/commun.js'></script>";

        //lancement du traitement des données
        $messageInscription = $this->registerUser();
        $messageConnection = $this->connectUser();

        //La view reçoit les données
        $this->getViewIdentificationUser()->setMessageConnection($messageConnection)->setMessageInscription($messageInscription);
        $this->getFooter()->setScriptInscription($script);

        //On fait l'affichage finale
        echo $this->getHeader()->displayView();
        echo $this->getViewIdentificationUser()->displayView();
        echo $this->getFooter()->displayView();

    }
}

$user = new IdentificationUserController(new ViewIdentificationUser(), new ModelUser());
$user->render();