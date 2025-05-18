<?php

    //création de la class ModelUser
    class ModelUser{

        //ATTRIBUTS
        // L'identifiant de l'utilisateur qui s'inscrit
        private ?int $idUser;
        // Le nom de l'utilisateur qui s'inscrit
        private ?string $loginUser;
        // L'email de l'utilisateur qui s'inscrit
        private ?string $mailUser;
        // Le mot de passe de l'utilisateur qui s'inscrit
        private ?string $passwordUser;
        // L'id du rôle de l'utilisateur qui s'inscrit (par défaut 1 car c'est celui de l'utilisateur et non de l'administrateur)
        private ?int $idRole;
        private ?PDO $bdd;   
        
        
        //CONSTRUCTOR
        public function __construct() {
            $this->bdd = connect();
            // L'id du rôle est défini sur un par défaut pour que tout nouvel inscript soit un utilisateur et non un administrateur
            $this->idRole = 1; 
        }

        // GETTERS & SETTERS
        public function getIdUser(): ?int {
            return $this->idUser;
        }

        public function setIdUser(int $idUser): ModelUser {
            $this->idUser = $idUser;
            return $this;
        }

        public function getLoginUser(): ?string {
            return $this->loginUser;
        }

        public function setLoginUser(string $loginUser): ModelUser {
            $this->loginUser = $loginUser;
            return $this;
        }

        public function getMailUser(): ?string {
            return $this->mailUser;
        }

        public function setMailUser(string $mailUser): ModelUser {
            $this->mailUser = $mailUser;
            return $this;
        }

        public function getPassWordUser(): ?string {
            return $this->passwordUser;
        }

        public function setPasswordUser(string $passwordUser): ModelUser {
            $this->passwordUser = $passwordUser;
            return $this;
        }

        public function getIdRole(): ?int {
            return $this->idRole;
        }

        public function setIdRole(int $idRole): ModelUser {
            $this->idRole = $idRole;
            return $this;
        }

        public function getBdd(): ?PDO {
            return $this->bdd;
        }

        public function setBdd(?PDO $bdd): ModelUser {
            $this->bdd = $bdd;
            return $this;
        }



        //METHOD
        //fonction qui ajoute un utilisateur dans la bdd
        public function addUser():string {
            try {

                //envoi de la requête sql avec la methode prepare() pour ajouter le utilisateur dans la table
                $reqUser = $this->getBdd()->prepare("INSERT INTO users (login_user, mail_user, password_user, id_role) VALUES (?, ?, ?, ?)");

                //Récupération des données depuis l'objet
                //il faut faire les get ici car bindParam ne les prend pas en compte
                $loginUser= $this->getLoginUser();
                $mailUser= $this->getMailUser();
                $passwordUser= $this->getPasswordUser();
                $idRole= $this->getIdRole();


                //binding des paramètres pour les remplacer les "?"
                $reqUser->bindParam(1, $loginUser, PDO::PARAM_STR);
                $reqUser->bindParam(2, $mailUser, PDO::PARAM_STR);
                $reqUser->bindParam(3, $passwordUser, PDO::PARAM_STR);
                $reqUser->bindParam(4, $idRole, PDO::PARAM_INT);

                //exécution de la requête avec execute()
                $reqUser->execute();

                //message de confirmation
                return "Bonjour $loginUser, votre compte a été créé.";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création de la fonction pour modifier un utilisateur
        public function changeUser(): string {

            try {
                // Préparer la requête pour modifier l'utilisateur grâce à son id
                $reqUser = $this->getBdd()->prepare("UPDATE users SET login_user = ?, mail_user= ?, password_user = ? WHERE id_User = ?");

                // Récupérer les données de l'objet
                $newLoginUser = $this->getLoginUser();
                $newMailUser = $this->getMailUser();
                $newPasswordUser = $this->getPasswordUser();
                $idUser = $this->getIdUser();
                
                // Binding des paramètres
                $reqUser->bindParam(1, $newLoginUser, PDO::PARAM_STR);
                $reqUser->bindParam(2, $newMailUser, PDO::PARAM_STR);
                $reqUser->bindParam(3, $newPasswordUser, PDO::PARAM_STR);
                $reqUser->bindParam(4, $idUser, PDO::PARAM_INT); 
                
        
                // Exécuter la requête
                $reqUser->execute();
        
                // Retourner un message de succès
                return "Le utilisateur avec l'id $idUser a été modifié.";
        
            } catch (EXCEPTION $error) {
                // En cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }



        //Création de la fonction pour supprimer un utilisateur par son ID 
        public function deleteUserById():string {
            try {

                //envoi de la requête sql avec la methode prepare() et DELETE pour supprimer le utilisateur dans la table
                $reqUser = $this->getBdd()->prepare("DELETE FROM users WHERE id_user = ?");

                //Récupération de l'objet
                $idUser= $this->getIdUser();

                $reqUser->bindParam(1, $idUser, PDO::PARAM_INT);
                

                // Exécuter la requête
                $reqUser->execute();

                //message de confirmation
                return "Le utilisateur $idUser a été supprimé";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }


        //Création de la fonction pour supprimer un utilisateur par son nom (le nom du utilisateur est unique dans la BDD pour ne pas supprimer le mauvais utilisateur)
        public function deleteUserByLogin():string {
            try {

                //envoi de la requête sql avec la methode prepare() et DELETE pour supprimer le utilisateur dans la table
                $reqUserByName = $this->getBdd()->prepare("DELETE FROM users WHERE login_user = ?");

                //Récupération de l'objet
                $loginUser= $this->getLoginUser();

                $reqUserByName->bindParam(1, $loginUser, PDO::PARAM_STR);
                

                // Exécuter la requête
                $reqUserByName->execute();

                //message de confirmation
                return "Le utilisateur $loginUser a été supprimé";

            } catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        
        //Création de la fonction getAllUsers() pour récupérer tous les utilisateurs
        public function getAllUsers(): string | array {
            try {
                //préparation de la requête avec un INNER JOIN pour récupérer le nom du utilisateur et le nom du container (sera afficher dans le tableau des utilisateurs dans viewAdmin avec le nom du container et pas seulement l'id du container). La jointure permet de récupérer le type du container de la table container pour qu'il puisse "appraître" dans la table User.
                $reqUser = $this->getBdd()->prepare('SELECT login_user, mail_user, password_user 
                FROM users');
    
                //exécution de la requête
                $reqUser->execute();
    
                //récupération des données de la BDD de la requête
                $data = $reqUser->fetchAll(PDO::FETCH_ASSOC);
                
                //retourne le tableau
                return $data;
    
            }catch(EXCEPTION $error) {
                //en cas de problème, récupération du message d'erreur et affichage de ce dernier
                return $error->getMessage();
            }
        }

        //Création de la fonction getByMailUser() pour récupérer un utilisateur par son mail
        public function getByMailUser(): string | array {
            try {

                //il faut faire les get ici car bindParam ne les prend pas en compte
                $mailUser= $this->getMailUser();

                //préparer la requête
                $reqUser = $this->getBdd()->prepare("SELECT id_user, login_user, mail_user, password_user FROM users WHERE mail_user = ? LIMIT 1 ");

                //Binding de param
                $reqUser->bindParam(1, $mailUser, PDO::PARAM_STR);

                //exécute la requête
                $reqUser->execute();

                //récupère les données de la BDD de la requête
                $data = $reqUser->fetchAll(PDO::FETCH_ASSOC);

                //retourne le tableau
                return $data;
        
            } catch(EXCEPTION $error) {
                return $error->getMessage();
            }
        }

        //Création de la fonction getByLoginUser() pour récupérer un utilisateur par son pseudo (utile pour afficher les informations du compte pour l'utilisateur)
        public function getByLoginUser(): string | array {
            try {

                //il faut faire les get ici car bindParam ne les prend pas en compte
                $loginUser= $this->getLoginUser();

                //préparer la requête
                $req = $this->getBdd()->prepare("SELECT id_user, login_user, mail_user, password_user, id_role FROM users WHERE login_user = ? LIMIT 1 ");

                //Binding de param
                $req->bindParam(1, $loginUser, PDO::PARAM_STR);

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

        //Création de la fonction getByIdUser() pour récupérer un utilisateur par son ID (utile pour afficher les informations du compte de l'utilisateur pour l'admin)
        public function getByIdUser(): string | array {
            try {

                //il faut faire les get ici car bindParam ne les prend pas en compte
                $idUser= $this->getIdUser();

                //préparer la requête
                $req = $this->getBdd()->prepare("SELECT id_user, login_user, mail_user, password_user FROM users WHERE id_user = ? LIMIT 1 ");

                //Binding de param
                $req->bindParam(1, $idUser, PDO::PARAM_INT);

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