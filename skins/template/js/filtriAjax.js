
    function inviaRichiestaFil(arrCategoria,arrGenere,arrMarca,arrPrezzo,size){
      if(arrCategoria.length===0){
        arrCategoria.push(-1);
      }
      if(arrGenere.length===0){
        arrGenere.push(-1);
      }
      if(arrMarca.length===0){
        arrMarca.push(-1);
      }
      if(size===undefined){
        size='U';
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
          $(document).ready(function(){
             // $("#divItems").html(response)
             //console.log(response)
             $("#divBodyShop").html(response);
          })
        },
        error: function(xhr, status, error) {
          console.log('Si è verificato un errore durante l\'invio della richiesta.');
        }
      });
    }
   
