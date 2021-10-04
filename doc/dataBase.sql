CREATE TABLE `usuarios` (
    `UsuarioId` INTEGER NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(128) NOT NULL,
    `Apellido` VARCHAR(128) NOT NULL,
    `Email` VARCHAR(256) NOT NULL,
    `Clave` VARCHAR(512) NOT NULL,
    `Activo` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`UsuarioId`)
);

CREATE TABLE `cuadernos` (
    `CuadernoId` INTEGER NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(256) NOT NULL,
    `UsuarioId` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`CuadernoId`)
);

CREATE TABLE `categoriasmovimiento` (
    `CategoriaId` INTEGER NOT NULL AUTO_INCREMENT,
    `Descripcion` VARCHAR(128) NOT NULL,
    `CuadernoId` INTEGER NOT NULL,
    `TipoId` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`CategoriaId`)
);

CREATE TABLE `tiposmovimiento` (
    `TipoId` INTEGER NOT NULL AUTO_INCREMENT,
    `Descripcion` VARCHAR(128) NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`TipoId`)
);

CREATE TABLE `movimientos` (
    `MovimientoId` INTEGER NOT NULL AUTO_INCREMENT,
    `Descripcion` VARCHAR(64) NOT NULL,
    `FechaPlanificado` DATE NOT NULL,
    `ValorPlanificado` INTEGER NOT NULL,
    `FechaReal` DATE NULL,
    `ValorReal` INTEGER NULL,
    `CuadernoId` INTEGER NOT NULL,
    `CategoriaId` INTEGER NOT NULL,
    `TipoId` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`MovimientoId`)
);

ALTER TABLE `movimientos` ADD FOREIGN KEY (`CuadernoId`) REFERENCES `cuadernos`(`CuadernoId`);
ALTER TABLE `movimientos` ADD FOREIGN KEY (`CategoriaId`) REFERENCES `categoriasmovimiento`(`CategoriaId`);
ALTER TABLE `cuadernos` ADD FOREIGN KEY (`UsuarioId`) REFERENCES `usuarios`(`UsuarioId`);
ALTER TABLE `categoriasmovimiento` ADD FOREIGN KEY (`CuadernoId`) REFERENCES `cuadernos`(`CuadernoId`);
