<?php
    // Retorna Fecha y Hora Actual Argentina
    function fechaHoraActual (){
        date_default_timezone_set(ZONA_HORARIA);
        return date('Y-m-d H:i:s');
    }
    // Verifica si existe sesion activa
    function sesionActiva(){
        if(isset($_SESSION['appKey'])){
            if( $_SESSION['appKey'] == APP_CLAVE){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Retorna UsuarioId si esta logueado
    function usuarioId(){
        return isset($_SESSION['usuarioId']) ? $_SESSION['usuarioId'] : '';
    }
    // Retorna UsuarioNombre si esta logueado
    function usuarioNombre(){
        return isset($_SESSION['usuarioNombre']) ? $_SESSION['usuarioNombre'] : '';
    }
    // Retorna UsuarioEmail si esta logueado
    function usuarioEmail(){
        return isset($_SESSION['usuarioEmail']) ? $_SESSION['usuarioEmail'] : '';
    }
    // Valida Usuario y Clave
    function validarUsuarioClave($email, $clave){

    }
    // Valida Fecha
    function validarFecha($fecha){
        $expRegFecha ='/\d{4}\-\d{2}-\d{2}/';
        return preg_match($expRegFecha, $fecha);
    }
    // Guarda datos de sesion
    function guardarSesion($usuarioId, $email, $nombre){
        $_SESSION['appKey'] = APP_CLAVE;
        $_SESSION['usuarioId'] = $usuarioId;
        $_SESSION['usuarioNombre'] = $nombre;
        $_SESSION['usuarioEmail'] = $email;
    }
    // Filtado de datos: Elimina espacios al inicio y fin, elimina slashes \, caracteres especias a entidades HTML
    function filtrado($palabra){
        $palabra = trim($palabra);
        $palabra = stripslashes($palabra);
        $palabra = htmlspecialchars($palabra);
        return $palabra;
    }
    // Retorna Hash con salt
    function generarHash($palabra){
        $salt = APP_NOMBRE;
        return hash('sha512', $salt . $palabra);
    }

    class RespuestaJSON {
        public $error = 'N';
        public $estado = 200;
        public $datos = array();

        private function renderJSON() {
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array(
                'datos' => $this->datos,
                'estado' => $this->estado,
                'error' => $this->error
            ));
        }

        public function generarJSON() {
            header("HTTP/1.1 200 OK");
            $this->estado = 200;
            $this->renderJSON();
        }

        public function recursoNoEncontrado(){
            header("HTTP/1.0 404 Not Found");
            $this->estado = 404;
            $this->renderJSON();
        }

        public function error(){
            header("HTTP/1.0 500 Error");
            $this->estado = 500;
            $this->renderJSON();
        }
    }


?>