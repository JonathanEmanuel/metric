<?php
    require_once './app/core/config.php';
    require_once './app/core/auxiliares.php';

    $display = "";
    if ( isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) &&
        isset($_POST['password-1']) && isset($_POST['password-2']) ){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password1 = $_POST['password-1'];
        $password2 = $_POST['password-2'];

        if ( $password1 == $password2 ){
            $password = $password1;
            $password = generarHash($password);
            //$result = registrarUsuario($nombre, $apellido, $email, $password);
            if ( $result ){
                //header('Location: '.URL.'/login.php');
            } else {
                $mensaje =  'Error al registrarse';
            }
        } else {
            $mensaje = 'Las contraseñas no coinciden';
        }

    } else {
        $mensaje = 'Faltan datos';
    }
    require ('app/views/registro.html');

?>
