CREATE TABLE `Usuarios` (
    `UsuarioId` INTEGER NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(128) NOT NULL,
    `Apellido` VARCHAR(128) NOT NULL,
    `Email` VARCHAR(256) NOT NULL,
    `Clave` VARCHAR(512) NOT NULL,
    `Activo` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`UsuarioId`)
);

CREATE TABLE `Cuadernos` (
    `CuadernoId` INTEGER NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(256) NOT NULL,
    `UsuarioId` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`CuadernoId`)
);

CREATE TABLE `CategoriasMovimiento` (
    `CategoriaId` INTEGER NOT NULL AUTO_INCREMENT,
    `Descripcion` VARCHAR(128) NOT NULL,
    `CuadernoId` INTEGER NOT NULL,
    `TipoId` INTEGER NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`CategoriaId`)
);

CREATE TABLE `TiposMovimiento` (
    `TipoId` INTEGER NOT NULL AUTO_INCREMENT,
    `Descripcion` VARCHAR(128) NOT NULL,
    `Borrado` DATE NULL,
    PRIMARY KEY (`TipoId`)
);

CREATE TABLE `Movimientos` (
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

ALTER TABLE `Movimientos` ADD FOREIGN KEY (`CuadernoId`) REFERENCES `Cuadernos`(`CuadernoId`);
ALTER TABLE `Movimientos` ADD FOREIGN KEY (`CategoriaId`) REFERENCES `CategoriasMovimiento`(`CategoriaId`);
ALTER TABLE `Cuadernos` ADD FOREIGN KEY (`UsuarioId`) REFERENCES `Usuarios`(`UsuarioId`);
ALTER TABLE `CategoriasMovimiento` ADD FOREIGN KEY (`CuadernoId`) REFERENCES `Cuadernos`(`CuadernoId`);
