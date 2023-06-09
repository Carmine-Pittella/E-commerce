
    function inviaRichiestaCat(valore) {
        dataT = {valore : valore, tipo: "categoria"};
        $.ajax({
          url: 'shop.php',
          type: 'POST',
          data: { valore: dataT},
          success: function(response) {
            console.log('successo:',response,'fine');
            // Puoi fare qualcos'altro con la risposta ottenuta
            $(document).ready(function(){
                $("#divItems").html(response)
            })
          },
          error: function(xhr, status, error) {
            console.log('Si è verificato un errore durante l\'invio della richiesta.');
          }
        });
    }
   
