function gotoShopUomo(){
    let arrCategoria = [];
    let arrGenere = [];
    let arrMarca = [];
    let arrPrezzo = [];
    let changePage = 1;
    size = "U";
    arrCategoria.push(-1);
    arrGenere.push(-1);
    arrMarca.push(-1);
    min = "$5"; max = "1000";arrPrezzo.push(min);arrPrezzo.push(max);
    dataT = { arrCategoria: arrCategoria, arrGenere: arrGenere, arrMarca: arrMarca, arrPrezzo: arrPrezzo, size, changePage };
        $.ajax({
           url: "shop.php",
           type: "POST",
           data: { valore: dataT},
           success: function (response) {
              console.log("gotoshopUomo");
           },
           error: function (xhr, status, error) {
              console.log("Si è verificato un errore durante l'invio della richiesta.");
           },
        });
     

}
function gotoShopDonna(){

}
function gotoShopBambini(){

}