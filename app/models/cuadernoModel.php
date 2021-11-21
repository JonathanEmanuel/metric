<?php
    require_once('app/core/ConexionDB.php');

    class CuadernoModelo extends ConexionPDO {
        public $cuadernoId;
        public $nombre;
        public $usuarioId;

        public function listarUsuario(){
            $this->query = "SELECT C.CuadernoId, C.Nombre 
                            FROM cuadernos C
                            WHERE C.Borrado IS NULL AND C.UsuarioId = :usuarioId ";
            $this->obtenerRows( array(
                ':usuarioId' => $this->usuarioId 
            ));
            return $this->rows;
        }

        public function guardar(){
            $this->query = "INSERT INTO cuadernos (Nombre, UsuarioId)
                            VALUES(:nombre, :usuarioId)";
            $this->ejecutar(array(
                ':nombre' => $this->nombre, 
                ':usuarioId' => $this->usuarioId
            ));
            $this->cuadernoId = $this->ultimoId();
        }

        public function actualizar(){
            $this->query = "UPDATE cuadernos
                            SET Nombre = :nombre 
                            WHERE CuadernoId = :cuadernoId AND UsuarioId = :usuarioId";
            $this->ejecutar(array(
                ':nombre' => $this->nombre,
                ':cuadernoId' => $this->cuadernoId,
                ':usuarioId' => $this->usuarioId
            ));
        }
    }

?>