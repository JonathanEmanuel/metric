<?php
    require_once(MODELOS . 'movimientoModel.php');

    class historialController {
        public $movimientoId;


        function __construct(){
            $this->respuestaJSON = new RespuestaJSON;
            $this->movimiento = new MovimientoModelo;

        }

        public function index($parametro = null) {
            $emailUsuario = usuarioEmail();

            require_once(VISTAS . 'header.html');
            require_once(VISTAS . 'historial.html');
            echo('<script src="public/js/historial.js?1"></script>');
            require_once(VISTAS . 'footer.html');
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
            $this->movimiento->anio = $anio;
            $resultados = $this->movimiento->ingresosSalidasAnio();
            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }

    }

?>