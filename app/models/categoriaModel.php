<?php
    require_once('app/core/ConexionDB.php');

    class CategoriaModelo extends ConexionPDO {
        public $usuarioId;
        public $categoriaId;
        public $tipoId;
        public $descripcion;
        public $cuadernoId;

        public function listar(){
            $this->query = "SELECT C.`CategoriaId`, C.`Descripcion`, C.`TipoId`
                            FROM categoriasmovimiento C 
                            WHERE C.`Borrado` IS NULL AND C.`CuadernoId` = :cuadernoId AND C.`TipoId` = :tipoId";
            $this->obtenerRows( array(':cuadernoId' => $this->cuadernoId, ':tipoId' => $this->tipoId ) );
            return $this->rows;
        }

        public function guardar(){
            $this->query = "INSERT INTO categoriasmovimiento(Descripcion, CuadernoId, TipoId)
                            VALUES(:descripcion, :cuadernoId, :tipoId)";
            $this->ejecutar(array(':descripcion' => $this->descripcion, ':cuadernoId' => $this->cuadernoId, ':tipoId' => $this->tipoId));
            $this->categoriaId = $this->ultimoId();
        }

        public function actualizar(){
            $this->query = "UPDATE categoriasmovimiento
                            SET Descripcion = :descripcion
                            WHERE CategoriaId = :categoriaId)";
            $this->ejecutar(array(':descripcion' => $this->descripcion, ':categoriaId' => $this->categoriaId));
        }
    }

?>