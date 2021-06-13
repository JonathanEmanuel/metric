<?php
    // Datos de Base de Datos
    define('SERVIDOR_HOST', 'localhost');
    define('NOMBRE_DB', 'metric');
    define('USUARIO_DB', 'root');
    define('CLAVE_DB', '');

    // Definiciones de constantes para toda la aplicacion
    define("CONTROLADORES", 'app/controllers/');
    define("MODELOS", 'app/models/');
    define("VISTAS", 'app/views/');
    
    define('ZONA_HORARIA', 'America/Argentina/Buenos_Aires');
    define('APP_NOMBRE', 'Metric_APP');
    define('APP_CLAVE', md5(APP_NOMBRE));

    // Constantes de informacion del usuario
    define('USUARIO_ID', 0);
    define('USUARIO_FOLDER', '');

?>