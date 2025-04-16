<?php

    //création de la class ModelUser
    class ModelWaste{

        //ATTRIBUTS
        // L'identifiant du déchet à ajouter
        private ?int $idWaste;
        // Le nom du déchet à ajouter
        private ?string $nameWaste;
        // Le container associé au déchet 
        private ?int $idContainer;    
        private ?PDO $bdd;

        //CONSTRUCTOR
        public function __construct() {
            $this->bdd = connect();
        }

        // GETTERS & SETTERS
        public function getIdWaste(): ?int {
            return $this->idWaste;
        }

        public function setIdWaste(int $idWaste): ModelWaste {
            $this->idWaste = $idWaste;
            return $this;
        }

        public function getNameWaste(): ?string {
            return $this->nameWaste;
        }

        public function setNameWaste(string $nameWaste): ModelWaste {
            $this->nameWaste = $nameWaste;
            return $this;
        }

        public function getIdContainer(): ?int {
            return $this->idContainer;
        }
    
        public function setIdContainer(?int $idContainer): ModelWaste {
            $this->idContainer = $idContainer;
            return $this;
        }

        public function getBdd(): ?PDO {
            return $this->bdd;
        }

        public function setBdd(?PDO $bdd): ModelWaste {
            $this->bdd = $bdd;
            return $this;
        }



        //METHOD

        //fonction qui ajoute un déchet dans la bdd
        public function addWaste():string {
            try {

                //envoi de la requête sql avec la methode prepare() pour ajouter le déchet dans la table
                $reqWaste = $this->getBdd()->prepare("INSERT INTO waste (name_waste, id_container) VALUES (?, ?)");

                //Récupération des données depuis l'objet
                //il faut faire les get ici car bindParam ne les prend pas en compte
                $nameWaste= $this->getNameWaste();
                $idContainer= $this->getIdContainer();


                //binding des paramètres pour les remplacer les "?"
                $reqWaste->bindParam(1, $nameWaste, PDO::PARAM_STR);
                $reqWaste->bindParam(2, $idContainer, PDO::PARAM_INT);

                //exécution de la requête avec execute()
                $reqWaste->execute();

                //récupération du nom du container pour l'afficher dans le message de confirmation
                //envoi de la requête sql avec un SELECT
                $reqContainer = $this->getBdd()->prepare("SELECT type_container FROM container WHERE id_container = ?");
                $reqContainer->bindParam(1, $idContainer, PDO::PARAM_INT);
                $reqContainer->execute();

                // Récupérer le type de container
                //$container est un tableau
                $container = $reqContainer->fetch(PDO::FETCH_ASSOC);
                $typeContainer = $container['type_container'];

                //message de confirmation
                return "Le déchet '$nameWaste', associé au(x) container(s) '$typeContainer', a été ajouté";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création de la fonction pour modifier un déchet
        public function changeWaste(): string {

            try {
                // Préparer la requête pour modifier le déchet grâce à son id
                $reqWaste = $this->getBdd()->prepare("UPDATE waste SET name_waste = ?, id_container = ? WHERE id_waste = ?");

                // Récupérer les données de l'objet
                $newNameWaste = $this->getNameWaste();
                $idContainer = $this->getIdContainer();
                $idWaste = $this->getIdWaste();
                
                // Binding des paramètres
                $reqWaste->bindParam(1, $newNameWaste, PDO::PARAM_STR);
                $reqWaste->bindParam(2, $idContainer, PDO::PARAM_INT);
                $reqWaste->bindParam(3, $idWaste, PDO::PARAM_INT); 
        
                // Exécuter la requête
                $reqWaste->execute();

                //récupération du nom du déchet pour l'afficher dans le message de confirmation
                //envoi de la requête sql avec un SELECT
                $reqwasteUpDated = $this->getBdd()->prepare("SELECT name_waste FROM waste WHERE id_waste = ?");
                $reqwasteUpDated->bindParam(1, $idWaste, PDO::PARAM_INT);
                $reqwasteUpDated->execute();

                // Récupérer le type de container
                //$container est un tableau
                $wasteUpDated = $reqwasteUpDated->fetch(PDO::FETCH_ASSOC);
                $typewaste = $wasteUpDated['name_waste'];
        
                // Retourner un message de succès
                return "Le nouveau déchet $typewaste avec l'id $idWaste a été ajouté.";
        
            } catch (EXCEPTION $error) {
                // En cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }



        //Création de la fonction pour supprimer un déchet par son ID 
        public function deleteWasteById():string {
            try {

                //envoi de la requête sql avec la methode prepare() et DELETE pour supprimer le déchet dans la table
                $reqWaste = $this->getBdd()->prepare("DELETE FROM waste WHERE id_waste = ?");

                //Récupération de l'objet
                $idWaste= $this->getIdWaste();

                $reqWaste->bindParam(1, $idWaste, PDO::PARAM_INT);
                

                // Exécuter la requête
                $reqWaste->execute();

                //message de confirmation
                return "Le déchet $idWaste a été supprimé";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }


        //Création de la fonction pour supprimer un déchet par son nom (le nom du déchet est unique dans la BDD pour ne pas supprimer le mauvais déchet)
        public function deleteWasteByName():string {
            try {

                //envoi de la requête sql avec la methode prepare() et DELETE pour supprimer le déchet dans la table
                $reqWasteByName = $this->getBdd()->prepare("DELETE FROM waste WHERE name_waste = ?");

                //Récupération de l'objet
                $nameWaste= $this->getNameWaste();

                $reqWasteByName->bindParam(1, $nameWaste, PDO::PARAM_STR);
                

                // Exécuter la requête
                $reqWasteByName->execute();

                //message de confirmation
                return "Le déchet $nameWaste a été supprimé";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }


        //Création de la fonction getAllWastes() pour récupérer tous les déchets
        public function getAllWastes(): string | array {
            try {
                //préparation de la requête avec un INNER JOIN pour récupérer le nom du déchet et le nom du container (sera afficher dans le tableau des déchets dans viewAdminWaste avec le nom du container et pas seulement l'id du container). La jointure permet de récupérer le type du container de la table container pour qu'il puisse "appraître" dans la table waste.
                //les déchets s'afficheront par ordre alphabétique par leur nom.
                $reqWaste = $this->getBdd()->prepare('SELECT w.id_waste, w.name_waste, w.id_container, c.type_container 
                FROM waste w
                INNER JOIN container c
                ON w.id_container = c.id_container
                ORDER BY w.name_waste');
    
                //exécution de la requête
                $reqWaste->execute();
    
                //récupération des données de la BDD de la requête
                $data = $reqWaste->fetchAll(PDO::FETCH_ASSOC);
                
                //retourne le tableau
                return $data;
    
            }catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }


        //Création de la fonction getByNameWaste() pour récupérer un déchet par son nom
        public function getByNameWaste(): string | array {
            try {

                //il faut faire les get ici car bindParam ne les prend pas en compte
                $nameWaste= $this->getNameWaste();

                //préparer la requête
                $req = $this->getBdd()->prepare("SELECT id_waste, name_waste, id_container FROM waste WHERE name_waste = ? LIMIT 1 ");

                //Binding de param
                $req->bindParam(1, $nameWaste, PDO::PARAM_STR);

                //exécution de la requête
                $req->execute();

                //récupération des données de la BDD de la requête
                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                //retourne le tableau
                return $data;
        
            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création de la fonction getByIdWaste() un déchet par son nom
        public function getByIdWaste(): string | array {
            try {

                //il faut faire les get ici car bindParam ne les prend pas en compte
                $idWaste= $this->getIdWaste();

                //préparer la requête
                $req = $this->getBdd()->prepare("SELECT id_waste, name_waste, id_container FROM waste WHERE id_waste = ? LIMIT 1 ");

                //Binding de param
                $req->bindParam(1, $idWaste, PDO::PARAM_INT);

                //exécution de la requête
                $req->execute();

                //récupération des données de la BDD de la requête
                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                //retourne le tableau
                return $data;
        
            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

    }