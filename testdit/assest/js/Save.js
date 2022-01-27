
function Save(){
   hideModel();
   msg();
   redirigir()

  
}

function hideModel(){
    $(document).ready(function(){
        $("button").click(function(){
          console.log('alv');
        //   $("#exampleModal").hide();
          $('#exampleModal').modal('hide')
        });
      });
}
function msg(){
    console.log('probando');
    Swal.fire(
        'Guardado!',
        'Se ha registrado correctamente!',
        'success'
      )
}

function redirigir(){
   window.location.href ="../QuestionUser.php"
}
