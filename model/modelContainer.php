<?php

    //Creation de la classe ModelContainer
    class ModelContainer {

        //ATTRIBUT
        private ?int $idContainer;
        private ?string $typeContainer;
        private ?PDO $bdd;

        //CONSTRUCT
        public function __construct() {
            $this->bdd = connect();
        }

        //GETTER SETTER
        public function getIdContainer(): ?int {
            return $this->idContainer;
        }

        public function setIdContainer(?int $idContainer): ModelContainer {
            $this->idContainer = $idContainer;
            return $this;
        }

        public function getTypeContainer(): ?string {
            return $this->typeContainer;
        }

        public function setTypeContainer(?string $typeContainer): ModelContainer {
            $this->typeContainer = $typeContainer;
            return $this;
        }

        public function getBdd(): ?PDO {
            return $this->bdd;
        }

        public function setBdd(?PDO $bdd): ModelContainer {
            $this->bdd = $bdd;
            return $this;
        }


        //METHOD

        //Création de la fonction qui ajoute un container dans la bb
        public function addContainer():string {
            try {

                //envoi de la requête sql avec la methode prepare()
                $req = $this->getBdd()->prepare("INSERT INTO container (id_container, type_container) VALUES (?, ?)");

                //Récupération des données depuis l'objet
                //il faut faire les get ici car bindParam ne les prend pas en compte
                $typeContainer= $this->getTypeContainer();
                $idContainer= $this->getIdContainer();


                //binding des paramètres pour les remplacer les "?"
                $req->bindParam(2, $typeContainer, PDO::PARAM_STR);
                $req->bindParam(3, $idContainer, PDO::PARAM_INT);

                //exécution de la requête avec execute()
                $req->execute();

                //message de confirmation
                return "Le container $typeContainer a été ajouté.";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création de la fonction getAllContainers() pour récupérer tous les containers
        public function getAllContainers(): string | array {
            try {
                //préparer la requête SELECT    
                $req = $this->getBdd()->prepare("SELECT id_container, type_container FROM container");
                    //exécute la requête
                $req->execute();
    
                //récupère les données de la BDD de la requête
                $data = $req->fetchAll(PDO::FETCH_ASSOC);
                
                //retourne le tableau
                return $data;
    
            }catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création d'une fonction pour récupérer un container par son id
        public function getByIdContainer():array | string{
            try{
                //Récupérer l'id' du container
                $idContainer = $this->getIdContainer();
    
                //Preparer la requête
                $req=$this->getBdd()->prepare('SELECT id_container, type_container FROM container WHERE id_container = ?');
    
                //Binding de Param
                $req->bindParam(1,$idContainer,PDO::PARAM_INT);
    
                //Exécution de la requête
                $req->execute();
    
                //Récupération de la réponse de la BDD
                $data = $req->fetchAll(PDO::FETCH_ASSOC);
    
                //Renvoie des données
                return $data;
    
            }catch(EXCEPTION $error){
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        
    }