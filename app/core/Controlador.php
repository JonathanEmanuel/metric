<?php
    require_once(VISTAS . 'respuestaVista.php');
    require_once(MODELOS . 'appModelp.php');

    class Controller {
        public $respuestaJSON;
        private $app;
        public $appName;
        public $appKey;
        public $id = 0;

        function __construct() {
            $this->respuestaJSON = new RespuestaJSON;
            $this->app =  new AppModelo;

        }

        public function validarKey(){
            // clave: ff23adeb0fd21127ff78834cf8592a03
            // app: crossPI
            // hash: clave + nombre

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if ( isset($_POST['clave']) && isset($_POST['app'])  ){
                    $this->app->clave = md5( $_POST['app'] . $_POST['clave'] );
                    $rows = $this->app->validar();

                    if( $this->app->estado == 'Conectado' ){
                        if (  count($rows) > 0 ){
                            $this->appName = $rows[0]['AppId'];
                            $this->appKey = $rows[0]['Nombre'];

                            $this->app->appId = $rows[0]['AppId'];

                            $this->app->fechaActual = fechaHoraActual();
                            $this->app->ip = obtenerIP();
                            $this->app->plataforma = plataformaUsuario();
                            $this->app->navegador = navegadorUsuario();

                            $this->app->guardarLog();
                            $this->id = $this->app->loginId;
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        $this->respuestaJSON->error();
                        return false;
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function validarAPP(){

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if ( isset($_POST['clave']) && isset($_POST['app'])  ){
                    $this->app->clave = md5( $_POST['app'] . $_POST['clave'] );
                    $rows = $this->app->validar();

                    if( $this->app->estado == 'Conectado' ){
                        if (  count($rows) > 0 ){
                            //print_r ( $rows[0]);
                            //echo $rows[0]['AppId'];
                            //echo $rows[0]['Nombre'];

                        } else {
                            $this->respuestaJSON->datos = 'Fallo en autenticación';
                            $this->respuestaJSON->generarJSON();
                        }

                    } else {
                        $this->respuestaJSON->error();
                    }

                } else {
                    $this->respuestaJSON->datos = 'Fallo en autenticación33';
                    $this->respuestaJSON->generarJSON();
                }

            }
            //$this->respuestaJSON = new RespuestaJSON;
        }


    }
    
?>