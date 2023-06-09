
    function inviaRichiestaFil(arrCategoria,arrGenere,arrMarca,arrPrezzo,size){
      if(size===undefined){
        size='U';
      }
      if(arrCategoria===undefined){
        console.log("categoria non definita");
      }
      if(arrGenere===undefined){
        console.log("genere non definito");
      }
      if(arrMarca===undefined){
        console.log("marca non definita");
      }
      dataT = {arrCategoria:arrCategoria,
              arrGenere:arrGenere,
              arrMarca:arrMarca,
              arrPrezzo:arrPrezzo,
              size
      }
      $.ajax({
        url: 'shop.php',
        type: 'POST',
        data: { valore: dataT},
        success: function(response) {
          console.log('successo:',response,'fine');
          /*
          $(document).ready(function(){
              $("#divItems").html(response)
          })
          */
        },
        error: function(xhr, status, error) {
          console.log('Si è verificato un errore durante l\'invio della richiesta.');
        }
      });
    }
   
