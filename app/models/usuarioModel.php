<?php
    require_once('app/core/ConexionDB.php');

    class UsuarioModelo extends ConexionPDO {
        public $usuarioId;
        public $nombre;
        public $apellido;
        public $email;
        public $clave;
        public $activo;

        public function guardar(){
            $this->query = "INSERT INTO usuarios (Nombre, Apellido, Email, Clave, Activo)
                            VALUES(:nombre, :apellido, :email, :clave, :activo)";
            $this->ejecutar(array(
                ':nombre' => $this->nombre,
                ':apellido' => $this->apellido,
                ':email' => $this->email,
                ':clave' => $this->clave,
                ':activo' => $this->activo
            ));
            $this->usuarioId = $this->ultimoId();
        }


        public function verificarEmail(){
            $this->query = "SELECT U.Email 
                            FROM usuarios U
                            WHERE U.Email = :email";
            $this->obtenerRows(array(
                ':email' => $this->email
            ));
            return $this->rows;
        }
    }

?>
