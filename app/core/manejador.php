<?php
    /*
    1. Obtiene la URI
    2. La Divide en fragmentos
    3. Cada Fragmeto sera leido como controlado/metodo/parametros
    4. Si Fueron pasados parametros seran pasados como un array
    */

function obtener_uri() {
	// Si existe la variable $_GET['url'] la asigna a $url, de lo contrario asigna la default
	if(isset($_GET["url"])) {
		$url = $_GET["url"];
	} else {
		$url = "index/index";  // Controlador default y metodo
	}

	// Crea un array con el string
	$url = explode("/", $url);
	// Define el Controlado, el metodo y los parametros
	$controlador = (isset($url[0])) ? $url[0] . "Controller" : "indexController";
	$metodo = (isset($url[1]) && $url[1] != null) ? $url[1] : "index";
	// Genera un array con los parametros
	if (isset($url[2]) && $url[2] != null) {
		$parametros = array_slice($url, 2);

	}else {
		$parametros = array();

	}

	$datos = array($controlador, $metodo, $parametros);
	return $datos;
}
?>