<?php

    class indexController {
        public $fechaHora;

        function __construct(){
            
        }

        public function index($parametro = null) {
            require_once(VISTAS . 'header.html');
            require_once(VISTAS . 'home.html');
            require_once(VISTAS . 'footer.html');

        }

    }

?>