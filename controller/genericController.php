<?php

    // Démarrage de la $_SESSION pour pouvoir y accéder
    // session_start();

    //Création de la classe GenericController
    class GenericController {

        //ATTRIBUT
        private ?ViewHeader $header;
        private ?ViewFooter $footer;

        //CONSTRUCTOR
        public function __construct(){
            $this->header = new ViewHeader();
            $this->footer = new ViewFooter();
        }
        
        //GETTER ET SETTER
        public function getHeader(): ?ViewHeader { 
            return $this->header; 
        }

        public function setHeader(?ViewHeader $header): GenericController { 
            $this->header = $header; 
            return $this; 
        }

        public function getFooter(): ?ViewFooter { 
            return $this->footer; 
        }
        
        public function setFooter(?ViewFooter $footer): GenericController { 
            $this->footer = $footer; 
            return $this; 
        }
}