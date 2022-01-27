<?php
session_start();

include 'Controllers/Config.php';
if (isset($_REQUEST['i'])) {
    if ($_REQUEST['i'] > 0) {
    } else {

        print("<script>alert('OOpsss, no se encontro el examen, consulta con tu profesor.')</script>");
        print("<script>window.location = 'index.php'</script>");
    }
} else {

    print("<script>alert('OOpsss, no se encontro el examen, consulta con tu profesor.')</script>");
    print("<script>window.location = 'index.php'</script>");
}

$idexamen = $_REQUEST['i'];
$consultarExamen = mysqli_query($con, "select * from examen where idexamen=$idexamen");
$rw = mysqli_fetch_array($consultarExamen);

if (!mysqli_num_rows($consultarExamen) > 0) {
    print("<script>alert('OOpsss, no se encontro el examen, consulta con tu profesor.')</script>");
    print("<script>window.location = 'index.php'</script>");
}

?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Test Dit</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        input[type=radio] {
            /*border: 0px;*/
            /*   width: 3%;
                height: 2em;*/
        }
    </style>
</head>

<body class="d-flex h-100 text-center ">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="">
            <div>
                <h6 class="float-md-start mb-0">WILMER PINZON</h6>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Features</a>
                    <a class="nav-link" href="#">Contact</a>
                </nav>
            </div>
        </header>

        <main class="border">
            <h1><b>Examen:</b> <small class="text-muted"><?php echo $rw['nombre'] ?></small>.</h1>
            <br>
            <div class="row" style="margin-left: 600px;">
                <form action="action/updatePreguntas.php" method="post">
                    <?php

                    $preguntas = mysqli_query($con, "select * from detalle_examen_preguntas where idexamen=$idexamen");
                    foreach ($preguntas as $preg) {

                        $idddetalle_examen_preguntas = $preg['idddetalle_examen_preguntas'];
                    ?>
                        <!-- <p><?php echo $preg['descripcion_pregunta'] ?></p> -->
                        <div class="row">
                            <div class="col-md-2" style="text-align:right;">
                                <label for="descripcion_pregunta_<?php echo $i ?>" class="text-dark"><b><?php echo $preg['descripcion_pregunta'] ?> :</b></label>
                            </div>
                            <div class="col-md-6" style="text-align:left;">
                                <?php
                                $respuestas = mysqli_query($con, "select * from detalle_examen_respuesta where idexamen=$idexamen and idddetalle_examen_preguntas=$idddetalle_examen_preguntas");
                                foreach ($respuestas as $resp) {
                                ?>
                                    <input value="<?php echo $resp['iddetalle_examen_respuesta']  ?>" class="" type="radio" name="descripcion_pregunta_<?php echo $idddetalle_examen_preguntas ?>" id="descripcion_pregunta_<?php echo $idddetalle_examen_preguntas ?>" /> <span><?php echo $resp['descripcion_respuesta'] ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <?php } ?>
                            </div>
                        </div>

                        <br>
                    <?php } ?>
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <button class="btn btn-success w-50" style="margin-left: 113px;">Guardar</button>
                            <input type="hidden" name="numero_preguntas" id="numero_preguntas" value="<?php echo mysqli_num_rows($preguntas) ?>">
                            <input type="hidden" id="idexamen" name="idexamen" value="<?php echo $_REQUEST['i'] ?>">
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </main>
        <footer class="mt-auto text-white-50">
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assest\js\Save.js"> </script>
    <script src="https://use.fontawesome.com/5e1dfdb92c.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

</body>

</html>


<script>
    var countResp = 1;

    function addListResp(id) {
        countResp++;
        console.log(id)
        $('#respuestas_dinamicas_' + id).append('<tr id="row' + countResp + '"><td><input type="text" name="respuesta_' + id + '[]" placeholder="Respuesta 1" class="form-control name_list" /></td><td><input type="radio" name="correcto_' + id + '[]"  class="name_list" /> Correcta</td> <td> <button type="button" name="remove" id="' + countResp + '" class="btn btn-danger btn_remove_respuesta">X</button> </td> </tr>');
    }


    $(document).on('click', '.btn_remove_respuesta', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
</script>


<script>
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/createExamen.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#result").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                console.log(datos)
                $("#result").html(datos);
                $('#save_data').attr("disabled", false);
                // hideModel();
                // redirigir()
                if (datos = 'ok') {
                    numero_preguntas = $('input:radio[name=numero_preguntas]:checked').val()
                    window.location = 'preguntas.php?numero_preguntas=' + numero_preguntas
                }
            }
        });
        event.preventDefault();
    })

    function copiarTexto() {
        // var copyText = document.getElementById("myInput");
        var copyText = $("#textURL");
        navigator.clipboard.writeText(copyText.text());
        $.notify("Enlace copiado al portapapeles", 'success');
    }
</script>