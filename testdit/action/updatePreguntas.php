<?php 
session_start();
include "../Controllers/Config.php";

if (isset($_REQUEST['numero_preguntas'])) {
	$numero_preguntas = mysqli_real_escape_string($con,(strip_tags($_POST['numero_preguntas'][$i],ENT_QUOTES)));
	$idexamen = mysqli_real_escape_string($con,(strip_tags($_POST['idexamen'][$i],ENT_QUOTES)));

	for ($i=1; $i <= intval($_REQUEST['numero_preguntas']) ; $i++) {  

		$iddetalle_examen_respuesta =  $_POST['descripcion_pregunta_'.$i];
		// echo "<br>";
		$update = mysqli_query($con,"UPDATE detalle_examen_respuesta set respuesta=1 where iddetalle_examen_respuesta=$iddetalle_examen_respuesta;");
		if ($update) {
			// echo 'ok';
			$_SESSION['resp'] = 'Felicitaciones, completaste el examen.';
			header("location: ../index.php");
		}
	}
}
?>