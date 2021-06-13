<?php
    require_once(MODELOS . 'movimientoTipoModel.php');

    class movimientoTipoController {
        public $fechaHora;
        private $tipo;

        function __construct(){
            $this->respuestaJSON = new RespuestaJSON;
            $this->tipo = new MovimientoTipoModelo;

        }

        public function index($parametro = null) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        // RETORNA LISTA
        public function listar($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            $resultados = $this->tipo->listar();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->tipo->estado == 'Conectado'  ? 'N' : $this->tipo->estado);
            $this->respuestaJSON->generarJSON();
        }



    }

?>