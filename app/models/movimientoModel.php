<?php
    require_once('app/core/ConexionDB.php');

    class MovimientoModelo extends ConexionPDO {
        public $movimientoId;
        public $cuadernoId;
        public $usuarioId;
        public $descripcion;
        public $categoriaId;
        public $valorPlanificado;
        public $valorReal;
        public $fechaPlanificado;
        public $fechaReal;
        public $tipoId;
        public $mes;
        public $anio;
        public $fechaInicio;
        public $fechaFinal;

        public function listar(){
            $this->query = "SELECT M.`MovimientoId`, M.`Descripcion`, M.`FechaPlanificado`, M.`ValorPlanificado`, M.`FechaReal`, M.`ValorReal`,
                                    M.CategoriaId, C.`Descripcion` AS Categoria, M.`Tipoid`
                            FROM movimientos M
                            INNER JOIN categoriasmovimiento C ON C.CategoriaId = M.CategoriaId
                            WHERE M.`Borrado` IS NULL AND M.`Tipoid` = :tipoId AND MONTH(M.`FechaPlanificado`) = :mes AND YEAR(M.`FechaPlanificado`) = :anio
                                AND M.`CuadernoId` = :cuadernoId";
            $this->obtenerRows( array(
                    ':tipoId' => $this->tipoId, 
                    ':cuadernoId' => $this->cuadernoId, 
                    ':mes' => $this->mes, 
                    ':anio' => $this->anio
                ) );
            return $this->rows;
        }

        public function guardar(){
            $this->query = "INSERT INTO movimientos(Descripcion, FechaPlanificado, ValorPlanificado, CuadernoId, CategoriaId, TipoId)
                            VALUES(:descripcion, :fechaPlanificado, :valorPlanificado, :cuadernoId, :categoriaId, :tipoId)";
            $this->ejecutar(array(  ':descripcion' => $this->descripcion, 
                                    ':fechaPlanificado' => $this->fechaPlanificado, 
                                    ':valorPlanificado' => $this->valorPlanificado,
                                    ':cuadernoId' => $this->cuadernoId,
                                    ':categoriaId' => $this->categoriaId,
                                    ':tipoId' => $this->tipoId
                                ));
            $this->movimientoId = $this->ultimoId();
        }

        public function actualizar(){
            $this->query = "UPDATE movimientos
                            SET Descripcion = :descripcion,
                                FechaPlanificado = :fechaPlanificado,
                                ValorPlanificado = :valorPlanificado,
                                CategoriaId = :categoriaId,
                                TipoId = :tipoId
                            WHERE MovimientoId = :movimientoId";
            $this->ejecutar(array(  ':descripcion' => $this->descripcion, 
                                    ':fechaPlanificado' => $this->fechaPlanificado, 
                                    ':valorPlanificado' => $this->valorPlanificado,
                                    ':categoriaId' => $this->categoriaId,
                                    ':tipoId' => $this->tipoId,
                                    ':movimientoId' => $this->movimientoId
                                ));
        }

        public function valoresReales(){
            $this->query = "UPDATE movimientos
                            SET FechaReal = :fechaReal,
                                ValorReal = :valorReal
                            WHERE MovimientoId = :movimientoId";
            $this->ejecutar(array(  ':fechaReal' => $this->fechaReal, 
                                    ':valorReal' => $this->valorReal,
                                    ':movimientoId' => $this->movimientoId
                                ));
        }

        public function resumenMes(){
            $this->query = "SELECT  SUM( CASE WHEN M.`Tipoid` = 1 THEN M.`ValorPlanificado` ELSE 0 END) AS Ingresos,
                                    SUM( CASE WHEN M.`Tipoid` = 2 THEN M.`ValorPlanificado` ELSE 0 END) AS Gastos,
                                    SUM( CASE WHEN M.`Tipoid` = 3 THEN M.`ValorPlanificado` ELSE 0 END) AS Ahorros
                            FROM movimientos M
                            WHERE M.`Borrado` IS NULL AND M.`CuadernoId` = :cuadernoId AND MONTH(M.`FechaPlanificado`) = :mes AND YEAR(M.`FechaPlanificado`) = :anio";
            $this->obtenerRows( array( ':cuadernoId' => $this->cuadernoId, ':mes' => $this->mes, ':anio' => $this->anio));
            return $this->rows;
        }

        public function ingresosSalidasAnio(){
            $this->query = "SELECT SUM( CASE WHEN M.`Tipoid` = 1 THEN M.`ValorPlanificado` ELSE 0 END) AS Ingresos,
                                SUM( CASE WHEN M.`Tipoid` = 2 THEN M.`ValorPlanificado` ELSE 0 END) AS Gastos,
                                MONTH(M.`FechaPlanificado`) AS Mes
                            FROM movimientos M
                            WHERE M.`Borrado` IS NULL AND M.`CuadernoId` = :cuadernoId AND YEAR(M.`FechaPlanificado`) = :anio
                            GROUP BY MONTH( M.`FechaPlanificado`)";
            $this->obtenerRows( array(':cuadernoId' => $this->cuadernoId, ':anio' => $this->anio));
            return $this->rows;
        }

        public function obtenerIngreso(){
            $this->query = "SELECT sum( ValorPlanificado) AS suma
                            FROM movimientos m 
                            WHERE  FechaPlanificado  >= :fechaInicio
                            AND FechaPlanificado  <= :fechaFinal
                            AND TipoId = 1";
            $this->obtenerRows( array(':fechaInicio' => $this->fechaInicio, ':fechaFinal' => $this->fechaFinal));
            return $this->rows;
        }
        public function obtenerEgreso(){
            $this->query = "SELECT sum( ValorPlanificado) AS suma
                            FROM movimientos m 
                            WHERE  FechaPlanificado  >= :fechaInicio
                            AND FechaPlanificado  <= :fechaFinal
                            AND TipoId = 2";
            $this->obtenerRows( array(':fechaInicio' => $this->fechaInicio, ':fechaFinal' => $this->fechaFinal));
            return $this->rows;
        }
    }

?>