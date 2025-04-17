<?php

//creation class ViewAdminWaste
    class ViewAdminWaste {
        //Nous n'aurons pas de constructeur dans cette classe car nous savons que c'est une phrase qui est attendu dans les attributs (string). Nous pouvons directement mettre une chaîne de caractère ici.
        private ?string $message = "";
        private ?string $messageDelete = "";
        private ?string $messageUpDate = "";
        private ?string $wastesTable ="";
        private ?string $containersList = "";


        //GETTER SETTER
        public function getMessage(): ?string {
                return $this->message;
        }

        public function setMessage(?string $message): ViewAdminWaste {
                $this->message = $message;
                return $this;
        }
        public function getMessageDelete(): ?string {
                return $this->messageDelete;
        }

        public function setMessageDelete(?string $messageDelete): ViewAdminWaste {
                $this->messageDelete = $messageDelete;
                return $this;
        }


        public function getMessageUpDate(): ?string {
                return $this->messageUpDate;
        }

        public function setMessageUpDate(?string $messageUpDate): ViewAdminWaste {
                $this->messageUpDate = $messageUpDate;
                return $this;
        }

        public function getWastesTable(): ?string {
                return $this->wastesTable;
        }

        public function setWastesTable(?string $wastesTable): ViewAdminWaste {
                $this->wastesTable = $wastesTable;
                return $this;
        }

        public function getContainersList(): ?string {
            return $this->containersList;
        }

        public function setContainersList(?string $containersList): ViewAdminWaste {
            $this->containersList = $containersList;
            return $this;
        }

        //METHOD 
        public function displayView(): string {
            return 
                "<main>
                    <section class='addWasteAdmin'>
                        <h2 id='titleList'>Tableau des déchets</h2>
                        <table style='max-width: 1450px;'>
                            <thead>
                                <tr>
                                    <th>Déchet</th>
                                    <th class='idWasteContainer'>id Déchet</th>
                                    <th>Type de Container</th>
                                    <th class='idWasteContainer'>id Container</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$this->getWastesTable()}
                            </tbody>
                        </table>
                        <p class='message'>{$this->getMessageDelete()}</p>
                        
                        <form method='post' action='index.php' class='adminForm'>
                            <label for='nameWaste'>Nom du déchet à ajouter</label>
                            <input type='text' name='nameWaste' id='nameWaste' placeholder='Entrer le nom du déchet' required>
                            <label for='idContainer'>Type(s) de container </label>
                            <select name='idContainer' id='idContainer'>
                                <option value=''>-- Choisir --</option>
                                {$this->getContainersList()}
                            </select>
                            <p class='message'>{$this->getMessage()}</p>
                            <button class='submitWaste' type='submit' name='submitAddWaste'>Ajouter</button>    
                        </form>

                        <form method='post' action='index.php' class='adminForm'>
                            <label for='idWasteUpDate'>ID du déchet à modifier</label>
                            <input type='number' name='idWasteUpDate' id='idWasteUpDate' placeholder='id du déchet à modifier' required>
                            <label for='nameWasteUpDate'>Nouveau nom du déchet </label>
                            <input type='text' name='nameWasteUpDate' id='nameWasteUpDate' placeholder='Entrer le nouveau nom du déchet'>
                            <label for='newIdContainer'>Type(s) de container </label>
                            <select name='newIdContainer' id='newIdContainer'>
                                <option value=''>-- Choisir --</option>
                                {$this->getContainersList()}
                            </select>
                            <p>{$this->getMessageUpDate()}</p>
                            <button class='submitWaste' type='submit' name='submitUpdateWaste'>Modifier</button>
                        </form>

                        <form method='post' action='index.php' class='adminForm'>
                            <label for='nameWasteToDelete'>Nom du déchet à supprimer</label>
                            <input type='text' name='nameWasteToDelete' id='nameWasteToDelete' placeholder='Entrer le nom du déchet'>
                            <button class='submitWaste' type='submit' name='submitDeleteWaste'>Supprimer</button>
                        </form>
                    </section>
                </main>";
        }
    }

    //mes boutons
    // <button class='submitWaste' type='submit' name='submitUpdateWaste'>Modifier</button>
    // <button class='submitWaste' type='submit' name='submitDeleteWaste'>Supprimer</button>

    //mon formulaire suppression
   