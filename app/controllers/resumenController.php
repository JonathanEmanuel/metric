<?php
    require_once(MODELOS . 'movimientoModel.php');
    class ResumenController {
        
        function __construct(){
            $this->respuestaJSON = new RespuestaJSON;
            $this->movimiento = new movimientoModelo;

        }

        public function index($parametro = null) {
            $emailUsuario = usuarioEmail();

            require_once(VISTAS . 'header.html');
            require_once(VISTAS . 'resumen.html');
            require_once(VISTAS . 'footer.html');
        }

        public function obtenerResumen(){
            $parametros = json_decode(file_get_contents("php://input"));


            

            $this->movimiento->fechaInicio = $parametros->fechaInicio;
            $this->movimiento->fechaFinal = $parametros->fechaFinal;
            $ingreso = $this->movimiento->obtenerIngreso()[0]["suma"];            
            $egreso = $this->movimiento->obtenerEgreso()[0]["suma"];
            
        
            $total = $ingreso - $egreso;
            $resultados = [$ingreso, $egreso, $total];

            $this->respuestaJSON->datos = $resultados;
            $this->respuestaJSON->error = ($this->movimiento->estado == 'Conectado'  ? 'N' : $this->movimiento->estado);
            $this->respuestaJSON->generarJSON();
        }
    }


?>