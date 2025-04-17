<?php

    //INCLUDES
    include './utils/utils.php';
    include './model/modelWaste.php';
    include './model/modelContainer.php';
    include './view/viewHeader.php';
    include './view/viewFooter.php'; 
    include './view/viewAdminWaste.php';
    include './controller/genericController.php';

    //Création de la classe AdminController
    class AdminController extends GenericController {

        //ATTRIBUT
        private ?ViewAdminWaste $viewAdminWaste;
        private ?ModelWaste $modelWaste;
        private ?ModelContainer $modelContainer;


        //CONSTRUCTOR
        public function __construct(?ViewAdminWaste $viewAdminWaste, ?ModelWaste $modelWaste, ?ModelContainer $modelContainer) {
            //Paramètres hérités du parent GenericController
            $this->setHeader(new ViewHeader());
            $this->setFooter(new ViewFooter());
            $this->viewAdminWaste = $viewAdminWaste;
            $this->modelWaste = $modelWaste;
            $this->modelContainer = $modelContainer;
        }


        //GETTER ET SETTER
        public function getViewAdminWaste(): ?ViewAdminWaste {
            return $this->viewAdminWaste;
        }

        public function setViewAdminWaste(?ViewAdminWaste $viewAdminWaste): AdminController {
            $this->viewAdminWaste = $viewAdminWaste;
            return $this;
        }

        public function getModelWaste(): ?ModelWaste {
            return $this->modelWaste;
        }

        public function setModelWaste(?ModelWaste $modelWaste): AdminController {
            $this->modelWaste = $modelWaste;
            return $this;
        }

        public function getModelContainer(): ?ModelContainer {
            return $this->modelContainer;
        }

        public function setModelContainer(?ModelContainer $modelContainer): AdminController {
            $this->modelContainer = $modelContainer;
            return $this;
        }


        //METHOD

        //Enregistrer un déchet avec la fonction registerWaste()
        public function registerWaste(): string {

            //1_ Vérifier la réception du formulaire
            if(isset($_POST['submitAddWaste'])) {

                //2_ Vérifier les champs vides
                if(empty($_POST['nameWaste']) || empty($_POST['idContainer'])) {
                    return 'Tous les champs ne sont pas remplis';
                }

                //3_ Nettoyer les données
                $nameWaste = clean($_POST['nameWaste']);
                $idContainer = clean($_POST['idContainer']);

                //4_ Vérifier que le déchet n'existe pas déjà en BDD
                //4.1_ Donner le nom du déchet au Model
                $this->getModelWaste()->setNameWaste($nameWaste);

                //4.2_ Demander au Model d'utiliser getByNameWaste()
                $data = $this->getModelWaste()->getByNameWaste();

                //4.3_ Vérifier si les données sont vides ou non
                if(!empty($data)) {
                    return 'Ce déchet a déjà été enregistré.';
                }

                //6_ Enregistrer le déchet en BDD
                //6.1_ Donner le nom du déchet et l'id du container au ModelWaste
                $this->getModelWaste()->setNameWaste($nameWaste)->setIdContainer($idContainer);


                //6.2_ Demander au model d'utiliser addWaste()
                $data = $this->getModelWaste()->addWaste();

                //7_ Retourne un message de confirmation
                return $data; 
            }
            return '';
        }


        //Modifier un déchet avec la fonction upDateWaste()
        public function upDateWaste(): string {
            ///1_ Vérifier la réception du formulaire
            if(isset($_POST['submitUpdateWaste'])) {

                //2_ Vérifier les champs vides
                if(empty($_POST['idWasteUpDate']) || empty($_POST['nameWasteUpDate']) || empty($_POST['newIdContainer'])) {
                    return 'Remplir tous les champs pour modifier le déchet';
                }

                //3_ Vérifier le format de l'id
                if(!filter_var($_POST["idWasteUpDate"], FILTER_VALIDATE_INT)) {
                    return "L'id n'est pas au bon format";
                }

                //4_ Nettoyer les données
                $idWaste = clean($_POST['idWasteUpDate']);
                $nameWaste = clean($_POST['nameWasteUpDate']);
                $idContainer = clean($_POST['newIdContainer']);

                //5_ Vérifier que le déchet existe déjà en BDD
                //5.1_ Donner l'id du déchet au Model
                $this->getModelWaste()->setIdWaste($idWaste);

                //5.2_ Demander au Model d'utiliser getByIdWaste(), la fonction qui permet de récupérer un déchet par son id
                $data = $this->getModelWaste()->getByIdWaste();

                //5.3_ Vérifier si les données sont vides ou non
                if(empty($data)) {
                    return 'Ce déchet n\'est pas enregistré.';
                }

                //6_ Modifier le déchet en BDD
                //6.1_ Donner le nouveau nom du déchet et l'id du container au ModelWaste
                $this->getModelWaste()->setNameWaste($nameWaste)->setIdContainer($idContainer);


                //6.2_ Demander au model d'utiliser changeWaste()
                $data = $this->getModelWaste()->changeWaste();

                //7_ Retourne un message de confirmation
                return $data; 
            }
            return '';
        }


        //Supprimer un déchet avec la fonction removeWasteById()
        public function removeWasteById(): string {
                //1_ Vérifier si le formulaire de modification est submit
                if (isset($_POST['submitDeleteById'])) {

                    //2_ Vérifier les champs vides
                //if(empty($_POST['nameWasteToDelete'])) {
                    //return 'Entrer un nom de déchet';
                //}

                //3_ Nettoyer les données
                $idWaste = clean($_POST['idWaste']);

                //4_ Vérifier que le déchet existe déjà en BDD
                //4.1_ Donner le nom du déchet au Model
                $this->getModelWaste()->setIdWaste($idWaste);

                //4.2_ Demander au Model d'utiliser getByIdWaste()
                $data = $this->getModelWaste()->getByIdWaste();

                //4.3_ Vérifier si les données sont vides ou non
                if(empty($data)) {
                    return 'Ce déchet n\'a pas été enregistré.';
                }

                //5_ Demander au modèle de supprimer le déchet en fonction de son id
                $data = $this->getModelWaste()->deleteWasteById();

                //6_ Retourne un message de confirmation
                return $data; 
            }
            return '';
        }

        
        //Autre façon de supprimer un déchet avec la fonction removeWasteByName() : permet de supprimer un déchet en entrant son nom dans le formulaire (permet de ne pas supprimer par "accident" une donnée dans la BDD)
        public function removeWasteByName(): string {
            //1_ Vérifier si le formulaire de modification est submit
            if (isset($_POST['submitDeleteWaste'])) {

                    //2_ Vérifier les champs vides
                if(empty($_POST['nameWasteToDelete'])) {
                    return 'Entrer un nom de déchet';
                }

                //3_ Nettoyer les données
                $nameWaste = clean($_POST['nameWasteToDelete']);

                //4_ Vérifier que le déchet existe déjà en BDD
                //4.1_ Donner le nom du déchet au Model
                $this->getModelWaste()->setNameWaste($nameWaste);

                //4.2_ Demander au Model d'utiliser getByNameWaste()
                $data = $this->getModelWaste()->getByNameWaste();

                //4.3_ Vérifier si les données sont vides ou non
                if(empty($data)) {
                    return 'Ce déchet n\'a pas été enregistré.';
                }

                //5_ Demander au modèle de supprimer le déchet en fonction de son id
                $data = $this->getModelWaste()->deleteWasteByName();

                //6_ Retourne un message de confirmation
                return $data; 
            }
            return '';
        }

        //Fonction pour afficher un tableau avec le nom des déchets, leur id, le type de container et l'id de ce dernier
        public function readWaste(): string {
            // 1_ Récupérer la liste des déchets depuis le modèle
            $data = $this->getModelWaste()->getAllWastes();
        
            // 2_ Mettre en forme les données grâce à une boucle
            // 2.1_ Déclaration de la variable d'affichage
            $wastesTable = '';
        
            // 2.2_Boucle pour parcourir les déchets et créer une ligne de tableau pour chaque déchet
            foreach ($data as $waste) {
                // Ajoute un élément au tableau avec le nom du déchet, l'id du déchet, l'id du container et le type du container
            $wastesTable .= "<tr>
                                <td>{$waste['name_waste']}</td>
                                <td>{$waste['id_waste']}</td>
                                <td>{$waste['type_container']}</td>
                                <td>{$waste['id_container']}</td>
                                <td>
                                    <form method='POST' action='index.php'>
                                        <input type='hidden' name='idWaste' value={$waste['id_waste']}>
                                        <button class='delete' type='submit' name='submitDeleteById'>X</button>
                                    </form>
                                </td>
                            </tr>";
            }
            // 3_ Retourner les données formatées
            return $wastesTable;
        }
        //Fonction pour afficher dynamiquement le nom des containers dans la liste des containers
        public function readContainer():string{
            //1_ Récupérer la liste des containers
            $data = $this->getModelContainer()->getAllContainers();
    
            //2_ Mettre en forme les donnée grâce à une boucle
            //2.1_ Déclaration de la variable d'affichage
            $containersList = '';
            foreach($data as $container){
                $containersList.="<option value='{$container['id_container']}'>{$container['type_container']}</option>";
            }
    
            //3_ retourne les données formatées
            return $containersList;
        }

        //Fonction pour afficher la vue
        public function render():void{
            //Traitement des données
            $message = $this->registerWaste();
            $messageDelete = $this->removeWasteById();
            $messageUpDate = $this->upDateWaste();
            $wastesTable = $this->readWaste();
            $containersList = $this->readContainer();

             //Déclaration de la variable d'affichage
             $script = "<script src='./scripts/commun.js'></script>";
    
            //La view reçoit les données
            $this->getViewAdminWaste()->setMessage($message)->setMessageDelete($messageDelete)->setMessageUpDate($messageUpDate)->setWastesTable($wastesTable)->setContainersList($containersList);
            $this->getFooter()->setScriptInscription($script);
    
            //ON FAIT L'AFFICHAGE FINALE
            echo $this->getHeader()->displayView();
            echo $this->getViewAdminWaste()->displayView();
            echo $this->getFooter()->displayView();
        }
    }

    $admin = new AdminController(new ViewAdminWaste(), new ModelWaste(), new ModelContainer());
    $admin->render();
