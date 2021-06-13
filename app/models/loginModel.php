<?php
    require_once('app/core/ConexionDB.php');

    class LoginModelo extends ConexionPDO {
        public $usuarioId;
        public $nombre;
        public $apellido;
        public $email;
        public $clave;

        public function validarEmailClave(){
            $this->query = "SELECT U.UsuarioId, U.Email
                            FROM usuarios U
                            WHERE U.Email = :email AND U.Clave = :clave";
            $this->obtenerRows(array(':email' => $this->email, ':clave' => $this->clave));
            return $this->rows;
        }
    }

?>

