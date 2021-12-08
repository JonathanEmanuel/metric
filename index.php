<?php
    session_start();
    require_once('app/core/manejador.php');
    require_once('app/core/config.php');
    require_once('app/core/auxiliares.php');
    require_once('app/models/loginModel.php');

    $datos = obtener_uri();
    $controlador = $datos[0];
    $metodo = $datos[1];
    $parametro = $datos[2];
    $path = CONTROLADORES . $controlador . ".php";
    $display = 'none';
    if( sesionActiva() ){
        if(file_exists($path)){
            require $path;
            $controlador = new $controlador();
        
            if(isset($metodo)){
                if(method_exists($controlador, $metodo)){
                    if(isset($parametro) && $parametro != null){
                        $controlador->{$metodo}($parametro);
                    }else{
                        $controlador->{$metodo}();
                    }			
                }else{
                    // Retorna un JSON con parametros vacios
                    header("Location: ./404.php");
                    //exit("Metodo invalido");
                }
            }
        }else{
            header("Location: ./404.php");
            //exit("controlador Invalido");
        }

    } else {
        if ( isset($_POST["email"]) && isset($_POST["clave"])){
            $email = filtrado($_POST['email']);
            $clave = generarHash($_POST['clave']);

            $login = new LoginModelo();
            $login->email = $email;
            $login->clave = $clave;
            $datos = $login->validarEmailClave();

            if ( count($datos) > 0 ){
                $usuario = $datos[0];
                guardarSesion($usuario['UsuarioId'], $usuario['Email'], $usuario['Nombre']);
                header("Location: ./index.php");

            } else {
                $display = 'block';
                require_once( VISTAS . 'login.html');
            }

        } else {
            require_once(VISTAS . 'login.html');
        }
    }


?>