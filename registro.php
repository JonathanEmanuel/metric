<?php
    require_once './app/core/config.php';
    require_once './app/core/auxiliares.php';
    require_once './app/models/usuarioModel.php';

    $display = "none";
    if ( isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) &&
        isset($_POST['password-1']) && isset($_POST['password-2']) ){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password1 = $_POST['password-1'];
        $password2 = $_POST['password-2'];

        if ( $password1 == $password2 ){
            $usuario = new UsuarioModelo();

            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->email = $email;

            $existe = $usuario->verificarEmail();

            if ( count($existe) > 0 ){
                $display = "block";
                $mensaje = $usuario->estado == 'Conectado' ? 'El email ya está registrado' : 'Error al registrarse';
                require ('app/views/registro.html');
                return;
            } 

            $usuario->clave = generarHash($password1);
            $usuario->activo = 1;

            $usuario->guardar();


            if ( $usuario->estado == 'Conectado' ){
                $mensaje =  'Registro correcto';
                require ('app/views/registroCorrecto.html');

            } else {
                $display = "block";
                $mensaje =  'Error al registrarse ';
                require ('app/views/registro.html');
            }
        } else {
            $display = "block";
            $mensaje = 'Las contraseñas no coinciden';
            require ('app/views/registro.html');
        }

    } else {
        $mensaje = '';
        require ('app/views/registro.html');
    }

?>
