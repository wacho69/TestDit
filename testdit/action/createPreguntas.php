<?php

session_start();
include "../Controllers/Config.php";


if (isset($_REQUEST['numero_preguntas'])) {
	$numero_preguntas = mysqli_real_escape_string($con,(strip_tags($_POST['numero_preguntas'][$i],ENT_QUOTES)));
	$idexamen = mysqli_real_escape_string($con,(strip_tags($_POST['idexamen'][$i],ENT_QUOTES)));

	//borro registro en las dos tblas para evitar crear duplicado
	$del1 = mysqli_query($con,"delete from detalle_examen_preguntas where idexamen=$idexamen");
	$del2 = mysqli_query($con,"delete from detalle_examen_respuesta where idexamen=$idexamen");

	for ($i=1; $i <= intval($_REQUEST['numero_preguntas']) ; $i++) {  

		//guardo lo que eh recibido
		$descripcion_pregunta_ = mysqli_real_escape_string($con,(strip_tags($_POST['descripcion_pregunta_'.$i],ENT_QUOTES)));
		//inserto la pregunta
		$InsertPregunta = mysqli_query($con,"insert into detalle_examen_preguntas (idexamen,descripcion_pregunta,fecha_registro) values (\"$idexamen\",\"$descripcion_pregunta_\",NOW())");
		if ($InsertPregunta) {
			// echo 'true';


			//consulto el ultimo id
			$lastPreguntas=mysqli_query($con,"select LAST_INSERT_ID(idddetalle_examen_preguntas) as last from detalle_examen_preguntas order by idddetalle_examen_preguntas desc limit 0,1 ");
			$rw=mysqli_fetch_array($lastPreguntas);
			$idddetalle_examen_preguntas =$rw['last']; // si todo sale ok, almaceno el ultimo id en memoria


			//guardo las respuestas//
			$cantidad_respuesta = count($_POST['respuesta_'.$i]);
			if($_POST['respuesta_'.$i][0]!="" ){
				for ($j=0; $j < $cantidad_respuesta; $j++) { 
					$idcv = $ultimoCvIngresado;
					$descripcion_respuesta = mysqli_real_escape_string($con,(strip_tags($_POST['respuesta_'.$i][$j],ENT_QUOTES)));
					// $correcta = mysqli_real_escape_string($con,(strip_tags($_POST['correcto_'.$i][$j],ENT_QUOTES)));
					$correcta = isset($_POST['correcto_'.$i][$j]) ? 1 : 0;
					// echo $correcta,"<br>";
					// $FormacionAcademica->add();
					$InsertResponse = mysqli_query($con,"insert into detalle_examen_respuesta (idddetalle_examen_preguntas,descripcion_respuesta,correcta,fecha_registro,idexamen) values (\"$idddetalle_examen_preguntas\",\"$descripcion_respuesta\",\"$correcta\",NOW(),\"$idexamen\")");
					if ($InsertResponse) {
						// echo 'true';
						unset($_SESSION['ultimoID']);
						unset($_SESSION['qtyPreguntas']);
						$_SESSION['resp'] = 'El examen ah sido creado con exito';
						header("location: ../index.php");


					}/*else{
						echo "insert into detalle_examen_respuesta (idddetalle_examen_preguntas,descripcion_respuesta,correcta,fecha_registro) values (\"$idddetalle_examen_preguntas\",\"$descripcion_respuesta\",\"$correcta\",NOW())";
						echo '<br>';
					}*/
				}
			}



		}
	}
}
?>