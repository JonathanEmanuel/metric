<?php
    require_once(MODELOS . 'movimientoModel.php');
    require_once(MODELOS . 'cuadernoModel.php');


    class movimientoController {
        public $movimiento;
        public $movimientoId;
        public $descripcion;
        public $fechaPlanificado;
        public $valorPlanificado;
        public $fechaReal;
        public $valorReal;
        public $categoriaId;
        public $cuadernoId;
        public $tipoId;
        public $respuestaJSON;
        public $cuaderno;

        function __construct(){
            $this->respuestaJSON = new RespuestaJSON;
            $this->movimiento = new MovimientoModelo;
            $this->cuaderno =  new CuadernoModelo;

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

            // Valida Mes
            if( property_exists( $parametroPOST, 'Mes' ) ){
                $mes = $parametroPOST->Mes;
                if( ! is_numeric($mes)){
                    $this->respuestaJSON->error = 'Formato invalido de Mes.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo Mes';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida Anio
            if( property_exists( $parametroPOST, 'Anio' ) ){
                $anio = $parametroPOST->Anio;
                if( ! is_numeric($anio)){
                    $this->respuestaJSON->error = 'Formato invalido de Anio.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo Anio';
                $this->respuestaJSON->generarJSON();
                return;
            }

            $this->cuaderno->usuarioId = usuarioId();
            $cuadernoId = $this->cuaderno->listarUsuario()[0]['CuadernoId'];

            $this->movimiento->mes = $mes;
            $this->movimiento->anio = $anio;
            $this->movimiento->tipoId = $tipoId;
            $this->movimiento->cuadernoId = $cuadernoId;
            $resultados = $this->movimiento->listar();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }

        // GUARDA MOVIMIENTO
        public function guardar($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida MovimientoId
            if( property_exists( $parametroPOST, 'MovimientoId' ) ){
                $movimientoId = $parametroPOST->MovimientoId;
                if( ! is_numeric($movimientoId)){
                    $this->respuestaJSON->error = 'Formato invalido de MovimientoId.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo MovimientoId';
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


            // Valida FechaPlanificado
            if( property_exists( $parametroPOST, 'FechaPlanificado' ) ){
                $fechaPlanificado = filtrado( $parametroPOST->FechaPlanificado);
                
            } else {
                $this->respuestaJSON->error = 'Falta el campo FechaPlanificado';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida ValorPlanificado
            if( property_exists( $parametroPOST, 'ValorPlanificado' ) ){
                $valorPlanificado = filtrado( $parametroPOST->ValorPlanificado);
                
            } else {
                $this->respuestaJSON->error = 'Falta el campo ValorPlanificado';
                $this->respuestaJSON->generarJSON();
                return;
            }

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

            $this->cuaderno->usuarioId = usuarioId();
            $cuadernoId = $this->cuaderno->listarUsuario()[0]['CuadernoId'];


            $this->movimiento->movimientoId = $movimientoId;
            $this->movimiento->descripcion = $descripcion;
            $this->movimiento->fechaPlanificado = $fechaPlanificado;
            $this->movimiento->valorPlanificado = $valorPlanificado;
            $this->movimiento->cuadernoId = $cuadernoId;
            $this->movimiento->categoriaId = $categoriaId;
            $this->movimiento->tipoId = $tipoId;

            if( $movimientoId == '0'){
                $this->movimiento->guardar();
            } else {
                $this->movimiento->actualizar();
            }


            $this->respuestaJSON->datos = array('MovimientoId' => $this->movimiento->movimientoId);
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }

        // SUMATORIA DE GASTOS DEL MES
        public function totales($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida Mes
            if( property_exists( $parametroPOST, 'Mes' ) ){
                $mes = $parametroPOST->Mes;
                if( ! is_numeric($mes)){
                    $this->respuestaJSON->error = 'Formato invalido de Mes.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo Mes';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida Anio
            if( property_exists( $parametroPOST, 'Anio' ) ){
                $anio = $parametroPOST->Anio;
                if( ! is_numeric($anio)){
                    $this->respuestaJSON->error = 'Formato invalido de Anio.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo Anio';
                $this->respuestaJSON->generarJSON();
                return;
            }

            $this->cuaderno->usuarioId = usuarioId();
            $cuadernoId = $this->cuaderno->listarUsuario()[0]['CuadernoId'];

            $this->movimiento->cuadernoId = $cuadernoId;
            $this->movimiento->mes = $mes;
            $this->movimiento->anio = $anio;
            $resultados = $this->movimiento->resumenMes();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }

        // SUMATORIA DE GASTOS E INGRESOS DEL ANIO
        public function ingresosSalidasAnio($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida Anio
            if( property_exists( $parametroPOST, 'Anio' ) ){
                $anio = $parametroPOST->Anio;
                if( ! is_numeric($anio)){
                    $this->respuestaJSON->error = 'Formato invalido de Anio.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo Anio';
                $this->respuestaJSON->generarJSON();
                return;
            }

            $this->cuaderno->usuarioId = usuarioId();
            $cuadernoId = $this->cuaderno->listarUsuario()[0]['CuadernoId'];

            $this->movimiento->anio = $anio;
            $this->movimiento->cuadernoId = $cuadernoId;
            $resultados = $this->movimiento->ingresosSalidasAnio();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }


        // GUARDA MARCA DE MOVIMIENTO CONFIRMADO
        public function marcarRealizado($parametro=null){
            $parametroPOST = json_decode(file_get_contents("php://input"));

            // Valida MovimientoId
            if( property_exists( $parametroPOST, 'MovimientoId' ) ){
                $movimientoId = $parametroPOST->MovimientoId;
                if( ! is_numeric($movimientoId)){
                    $this->respuestaJSON->error = 'Formato invalido de MovimientoId.';
                    $this->respuestaJSON->generarJSON();
                    return;
                }
            } else {
                $this->respuestaJSON->error = 'Falta el campo MovimientoId';
                $this->respuestaJSON->generarJSON();
                return;
            }

            // Valida ValorPlanificado
            if( property_exists( $parametroPOST, 'ValorPlanificado' ) ){
                $valorPlanificado = filtrado( $parametroPOST->ValorPlanificado);
            } else {
                $this->respuestaJSON->error = 'Falta el campo ValorPlanificado';
                $this->respuestaJSON->generarJSON();
                return;
            }


            $this->movimiento->movimientoId = $movimientoId;
            $this->movimiento->fechaReal = fechaHoraActual();
            $this->movimiento->valorReal = $valorPlanificado;
            $this->movimiento->valoresReales();

            $this->respuestaJSON->datos = array('MovimientoId' => $this->movimiento->movimientoId);
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }

    }

?>