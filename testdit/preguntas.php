<?php
session_start();

include 'Controllers/Config.php';
if (isset($_SESSION['ultimoID']) and isset($_REQUEST['numero_preguntas'])) {
    if ($_SESSION['ultimoID'] > 0 and $_SESSION['ultimoID'] != 'ERRORNOTFOUND') {
    } else {

        print("<script>alert('Por favor, registra un nuevo examen..')</script>");
        print("<script>window.location = 'index.php'</script>");
    }
} else {

    print("<script>alert('Por favor, registra un nuevo examen..')</script>");
    print("<script>window.location = 'index.php'</script>");
}

$idexamen = $_SESSION['ultimoID'];
$consultarExamen = mysqli_query($con, "select * from examen where idexamen=$idexamen");
$rw = mysqli_fetch_array($consultarExamen);

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
</head>

<body class="d-flex h-100 text-center ">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="">
            <div>
                <h6 class="float-md-start mb-0">WILMER PINZON</h6>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <!-- <a class="nav-link" href="#">Features</a> -->
                    <a class="nav-link" href="#">Contact</a>
                </nav>
            </div>
        </header>

        <main class="border ">
            <h1 style="margin-left: -280px;">Examen: <small class="text-muted"><?php echo $rw['nombre'] ?></small>.</h1>
            <br>
            <span  id="textURL" style="margin-left: -349px;">
                <?php
                $link = APP_URL . "examen.php?i=$idexamen&c=" . sha1(md5(rand(2, 50)));
                echo $link;
                ?>
                <a href="#" onclick="copiarTexto()" class="btn btn-success"> <i class="fa fa-copy"></i></a>
            </span>

            <form action="action/createPreguntas.php" method="post">
                <!-- valido que el usuario no ingrese manualmente parametros y evitar confusion del total ingresado. -->
                <?php for ($i = 1; $i <= $_SESSION['qtyPreguntas']; $i++) {  ?>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="descripcion_pregunta_<?php echo $i ?>" class="text-dark"><b>PREGUNTA: <?php echo $i ?>:</b></label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" style="margin-left: 28px; width: 97%;" type="text" name="descripcion_pregunta_<?php echo $i ?>" id="descripcion_pregunta_<?php echo $i ?>" placeholder="Pregunta <?php echo $i ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6" style="padding-left: 40px;">

                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="respuestas_dinamicas_<?php echo $i ?>">
                                        <tr>
                                            <td>
                                                <input type="text" name="respuesta_<?php echo $i ?>[]" placeholder="Respuesta 1" class="form-control name_list" />
                                            </td>
                                            <td>
                                                <input type="radio" name="correcto_<?php echo $i ?>[]" class="name_list" /> Correcta
                                            </td>
                                            <td>
                                                <button onclick="addListResp(<?php echo $i ?>)" type="button" name="addlistResp" id="addlistResp" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <br>
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-primary w-50" style="margin-left: 585px;">Guardar</button>
                        <input type="hidden" name="numero_preguntas" id="numero_preguntas" value="<?php echo intval($_REQUEST['numero_preguntas']) ?>">
                        <input type="hidden" id="idexamen" name="idexamen" value="<?php echo $_SESSION['ultimoID'] ?>">
                    </div>
                </div>
                <br>
            </form>
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
        $('#respuestas_dinamicas_' + id).append('<tr id="row' + countResp + '"><td><input type="text" name="respuesta_' + id + '[]" placeholder="Respuesta 1"  class="form-control name_list" /></td><td><input type="radio" name="correcto_' + id + '[]"  class="name_list" /> Correcta</td> <td> <button type="button" name="remove" id="' + countResp + '" class="btn btn-danger btn_remove_respuesta">X</button> </td> </tr>');
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
             
                if (datos = 'ok') {
                    numero_preguntas = $('input:radio[name=numero_preguntas]:checked').val()
                    window.location = 'preguntas.php?numero_preguntas=' + numero_preguntas
                }
            }
        });
        event.preventDefault();
    })

    function copiarTexto() {
        var copyText = $("#textURL");
        navigator.clipboard.writeText(copyText.text());
        $.notify("Enlace copiado al portapapeles", 'success');
    }
</script>