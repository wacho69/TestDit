<?php 
	$config = array(
		"host"=>"localhost",
		"user"=>"root",
		"password"=>"",
		"db"=>"testdit"
	);


	define('DB_HOST', $config['host']);//DB_HOST:  generalmente suele ser "127.0.0.1"
	define('DB_USER', $config['user']);//Usuario de tu base de datos
	define('DB_PASS', $config['password']);//Contraseña del usuario de la base de datos
	define('DB_NAME', $config['db']);//Nombre de la base de datos

	$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        @die("<h2 style='text-align:center'>Imposible conectarse a la base de datos! </h2>".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        @die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
    mysqli_query($con,"SET NAMES 'utf8'");

    header("Content-Type: text/html;charset=utf-8");


    // error_reporting(E_ALL);
    define('APP_URL', 'http://localhost/testdit/');//Nombre de la base de datos
?>