<?php
    require_once('config.php');

    // Al finalizar las consultas ejecutar metodo desconectar()
    class ConexionPDO { 
        private $servername = "fdb34.awardspace.net";
        private $dbname = "3955252_metric";
        private $username = "3955252_metric";
        private $password = "metric95800263";
        private $objPDO;
        protected $query = "";
        protected $rows = array();
        public $estado = "";

        function  __construct(){
            $this->conectar();
        }

        // Conecta con la db y asigna estado = "Conectado"
        private function conectar() {
            try{
                $this->objPDO = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password,
                                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); // codificación de caracteres uft-8
                $this->objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->estado = "Conectado";
              }catch(PDOException $e){
                $this->estado = "ERROR: " . $e->getMessage();
                echo( $e->getMessage() );
            }
        }

        // Termina la conexion y asigna estado = "Desconectado"
        public function desconectar(){
            $this->objPDO = null;
            $this->estado = "Desconectado";
        }

        // Ejecuta una consulta SQL. Espera recibir un array asociativos como parametros
        public function ejecutar($parametros=""){
            try {
                if( is_array($parametros)){
                    $consulta =  $this->objPDO->prepare($this->query);
                    $consulta->execute($parametros);

                } else {
                    $resultado =  $this->objPDO->prepare($this->query);
                    $resultado->execute();
 
                }
            } catch (PDOException $e) {
                $this->estado = "ERROR: " . $e->getMessage();
                //$this->desconectar();
            }


        }

        // Ejecuta una consulta con resultado en un Array asociativo. Espera recibir un array Asociativo 
        // como parametros, si no se pasan parametros Ejecuta la consulta sin parametros
        public function obtenerRows($parametros=""){
            try {
                if( is_array($parametros)){
                    //echo("Con PARAMETROS </br>");
                    $consulta =  $this->objPDO->prepare($this->query);
                    $consulta->execute($parametros);
                    $this->rows =  $consulta->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    //echo("Sin parametros");
                    $consulta =  $this->objPDO->prepare($this->query);
                    $consulta->execute();
                    $this->rows =  $consulta->fetchAll(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                $this->estado = "ERROR: " . $e->getMessage();
            }
        }

        // Retorna ultmo Id Insertado
        public function ultimoId(){
            try {
                return $this->objPDO->lastInsertId();
            } catch (PDOException $e) {
                $this->estado = "ERROR: " . $e->getMessage();
            }
        }

        // Parametros Enteros
        public function parametrosEnteros(){
            $this->objPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        
    }

?>