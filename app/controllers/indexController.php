<?php
    //require_once(VISTAS. 'usuarioView.php');
    //require_once(MODELOS . 'usuarioModel.php');

    class indexController {
        public $fechaHora;
        private $autenticacion;

        function __construct(){
            //$this->usuario = new UsuarioModelo;
            //$this->respuestaJSON = new UsuarioVista;
        }

        public function index($parametro = null) {
            require_once(VISTAS . 'header.html');
            require_once(VISTAS . 'home.html');
            echo('<script src="public/js/app.js?2"></script>');
            require_once(VISTAS . 'footer.html');

        }

        // RETORNA AUTENTICACIONES DE LA FECHA
        public function deFecha($parametro=null){

            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida Fecha
            if( property_exists( $parametroPOST, 'Fecha' ) ){
                $fecha = $parametroPOST->Fecha;
                $expRegFecha ='/\d{4}\-\d{2}-\d{2}/';
                if( ! preg_match($expRegFecha, $fecha)){
                    $this->respuestaJSON->error = 'Formato invalido de Fecha.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo fechas';
                $this->respuestaJSON->generarJSON();
                return;
            }
            

            $this->autenticacion->fecha = $fecha;;
            $resultados = $this->autenticacion->pendientesAprobacionFecha();

            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->autenticacion->estado == 'Conectado'  ? 'N' : $this->autenticacion->estado);
            $this->respuestaJSON->renderJSON();
        }

    }

?>