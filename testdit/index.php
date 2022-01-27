<?php
session_start();
include 'Controllers/Config.php';
?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Test Dit</title>
    <!-- Bootstrap core CSS -->
    <link href="assest/css/cover.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
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

        <main class="px-3">
            <h1>TEST DIT.</h1>
            <br>
            <h1> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> CREAR NUEVO EXAMEN </button></h1>

            <table border="" class="table table-bordered " id="mydatatable">
                <thead>
                    <th>Descripcion</th>
                    <th>Total preguntas</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    <?php
                    $examenes  = mysqli_query($con, "select * from examen");
                    foreach ($examenes as $examen) {
                        $idexamen = $examen['idexamen'];
                    ?>
                        <tr>
                            <td><?php echo $examen['nombre'] ?></td>
                            <td><?php echo $examen['numero_preguntas'] ?></td>
                            <td>
                                <?php
                                $link = APP_URL . "examen.php?i=$idexamen&c=" . sha1(md5(rand(2, 50)));
                                ?>
                                <a href="#" title="Copiar enlce" onclick=" copiarTexto('<?php echo $link; ?>')" class="btn btn-success"> <i class="fa fa-copy"></i></a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </main>

        <footer class="mt-auto text-white-50">
        </footer>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="post" name="add" id="add">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title text-dark" id="exampleModalLabel" style="margin-left:140px;"><b>DETALLE DE EXAMENES</b></p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div id="result"></div>
                        <div class="container">

                            <div class="row">
                                <label for="nombre" class="text-dark" style="margin-left: -65px;"><b> Especificamos datos del examen</b></label>

                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="nombre" class="text-dark"><b>Nombre Proyecto:</b></label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="nombre" id="nombre" />
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="text-dark"><b>Cantidad Pregunta:</b></label>
                                </div>

                                <div class="col-md-6 text-left text-dark border rounded ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="numero_preguntas" id="numero_preguntas1" value="1" checked>
                                        <label class="form-check-label" for="numero_preguntas1"> 1 </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="numero_preguntas" id="numero_preguntas2" value="2">
                                        <label class="form-check-label" for="numero_preguntas2"> 2 </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="numero_preguntas" id="numero_preguntas2" value="3">
                                        <label class="form-check-label" for="numero_preguntas2"> 3 </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="numero_preguntas" id="numero_preguntas2" value="4">
                                        <label class="form-check-label" for="numero_preguntas2"> 4 </label>
                                    </div>
                                    <div class="form-check text-right">
                                        <input class="form-check-input" type="radio" name="numero_preguntas" id="numero_preguntas2" value="5">
                                        <label class="form-check-label " for="numero_preguntas2"> 5 </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="save_data" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>

                </div>
               
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assest\js\Save.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="https://use.fontawesome.com/5e1dfdb92c.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

</body>

</html>

<script>
    $(function() {

        var t = $('#mydatatable').DataTable({
            "bPaginate": true,
            'pageLength': 15,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "paging": true,

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
            },
            // "order": [[ 4, "asc" ]],
            drawCallback: function() {

            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]

        });

    });


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

    <?php if (isset($_SESSION['resp'])) { ?>
        $.notify("<?php echo $_SESSION['resp'] ?>", 'success');
    <?php
        unset($_SESSION['resp']);
    }
    ?>


    function copiarTexto(text) {
        navigator.clipboard.writeText(text);
        $.notify("Enlace copiado al portapapeles", 'success');
    }
</script>