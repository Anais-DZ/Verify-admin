<?php

    //creation de la classe viewFooter
    class ViewFooter {

        //ATTRIBUT
        private ?string $script;

        //GETTER ET SETTER
        public function getScripInscription(): ?string {
            return $this->script;
        }

        public function setScriptInscription(?string $script): ViewFooter {
            $this->script = $script;
            return $this;
        }

        //METHOD 
        public function displayView(): string {
            return
                    "<footer>
                        <a href='contact.html' alt='lien page contact' id='contactLien'>Contact</a>
                        <picture>
                            <source srcset='./Images/herbe.webp' type='image/webp' />
                            <source srcset='./Images/herbe.png' type='image/png' /> 
                            <img id='dessinHerbeFooter' src='./Images/herbe.png' alt='brin d'herbe dessiné'>
                        </picture>
                        <p>Copyright© 2024 | Design by <a class='attribution' href='https://www.freepik.com/' target='_blank' alt='lien page freepik'>Freepik</a> & <a class='attribution' href='https://anais-diez.vercel.app/' target='_blank' alt='lien page perso'>Anaïs DIEZ</a>
                        </p>
                    </footer>
                    {$this->getScripInscription()}
                </body>
                </html>";
        }
    }