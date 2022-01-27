<?php
	
	session_start();
	include '../Controllers/Config.php';
	// echo 'asd'

	$nombre  = mysqli_real_escape_string($con,(strip_tags($_POST['nombre'],ENT_QUOTES)));
	$numero_preguntas  = mysqli_real_escape_string($con,(strip_tags($_POST['numero_preguntas'],ENT_QUOTES)));

	$insert = mysqli_query($con,"insert into examen (nombre, numero_preguntas, fecha_registro) values (\"$nombre\",\"$numero_preguntas\", NOW())");



	if ($insert) {
		echo 'ok';
		
		//consulto el ultimo id
		$last=mysqli_query($con,"select LAST_INSERT_ID(idexamen) as last from examen order by idexamen desc limit 0,1 ");
		$rw=mysqli_fetch_array($last);
		$_SESSION['ultimoID'] =$rw['last']; // si todo sale ok, almaceno el ultimo id en memoria
		$_SESSION['qtyPreguntas'] =$numero_preguntas; // si todo sale ok, almaceno el ultimo id en memoria

	}else{
		$_SESSION['ultimoID'] = 'ERRORNOTFOUND';
		echo 'error';
	}
?>