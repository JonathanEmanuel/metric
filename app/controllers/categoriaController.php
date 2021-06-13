<?php
    require_once(MODELOS . 'categoriaModel.php');

    class categoriaController {
        public $fechaHora;
        private $autenticacion;

        function __construct(){
            $this->respuestaJSON = new RespuestaJSON;
            $this->categoria = new CategoriaModelo;

        }

        public function index($parametro = null) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        // RETORNA LISTA
        public function listar($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida TipoId
            if( property_exists( $parametroPOST, 'TipoId' ) ){
                $tipoId = $parametroPOST->TipoId;
                if( ! is_numeric($tipoId)){
                    $this->respuestaJSON->error = 'Formato invalido de TipoId.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo TipoId';
                $this->respuestaJSON->generarJSON();
                return;
            }
            $this->categoria->cuadernoId = 1;
            $this->categoria->tipoId = $tipoId;
            $resultados = $this->categoria->listar();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->categoria->estado == 'Conectado'  ? 'N' : $this->categoria->estado);
            $this->respuestaJSON->generarJSON();
        }

        // GUARDA CATEGORIA
        public function guardar($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida CategoriaId
            if( property_exists( $parametroPOST, 'CategoriaId' ) ){
                $categoriaId = $parametroPOST->CategoriaId;
                if( ! is_numeric($categoriaId)){
                    $this->respuestaJSON->error = 'Formato invalido de CategoriaId.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo CategoriaId';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida TipoId
            if( property_exists( $parametroPOST, 'TipoId' ) ){
                $tipoId = $parametroPOST->TipoId;
                if( ! is_numeric($tipoId)){
                    $this->respuestaJSON->error = 'Formato invalido de TipoId.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo TipoId';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida Descripcion
            if( property_exists( $parametroPOST, 'Descripcion' ) ){
                $descripcion = filtrado( $parametroPOST->Descripcion);
                
            } else {
                $this->respuestaJSON->error = 'Falta el campo Descripcion';
                $this->respuestaJSON->generarJSON();
                return;
            }

            $this->categoria->cuadernoId = 1;
            $this->categoria->categoriaId = $categoriaId;
            $this->categoria->tipoId = $tipoId;
            $this->categoria->descripcion = $descripcion;

            if( $categoriaId == '0'){
                $this->categoria->guardar();
            } else {
                $this->categoria->actualizar();
            }


            $this->respuestaJSON->datos = array('CategoriaId' => $this->categoria->categoriaId);
            $this->respuestaJSON->error = ($this->categoria->estado == 'Conectado'  ? 'N' : $this->categoria->estado);
            $this->respuestaJSON->generarJSON();
        }

    }

?>