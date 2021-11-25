<?php

    require_once(MODELOS . 'cuadernoModel.php');

    class indexController {
        public $fechaHora;
        private $cuaderno;

        function __construct(){
            $this->cuaderno = new cuadernoModelo();
        }

        public function index($parametro = null) {
            $this->cuaderno->usuarioId = usuarioId();
            $cuadernos = $this->cuaderno->listarUsuario();
            if ( count($cuadernos) == 0 ) {
                $this->cuaderno->nombre = 'Cuaderno Principal de ' . usuarioNombre();
                $this->cuaderno->usuarioId = usuarioId();
                $this->cuaderno = $this->cuaderno->guardar();
            } else {
                $cuadernoId = $cuadernos[0]['CuadernoId'];
            }
            //print_r($cuadernos);
            //echo '<br>' . 'Nombre ' . usuarioEmail();
            $emailUsuario = usuarioEmail();
            require_once(VISTAS . 'header.html');
            require_once(VISTAS . 'home.html');
            require_once(VISTAS . 'footer.html');

        }

    }

?>