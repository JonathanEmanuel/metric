<?php
    require_once('app/core/ConexionDB.php');

    class MovimientoTipoModelo extends ConexionPDO {
        public $tipoId;
        public $descripcion;

        public function listar(){
            $this->query = "SELECT T.`TipoId`, T.`Descripcion`
                            FROM tiposmovimiento T
                            WHERE T.`Borrado` IS NULL";
            $this->obtenerRows();
            return $this->rows;
        }

    }

?>