window.onbeforeunload = function (e) {
    console.log("Stai per lasciare la pagina. Sei sicuro di voler continuare?");
    // e = e || window.event; // IE fix

    // // Messaggio di conferma
    // var messaggio = "Stai per lasciare la pagina. Sei sicuro di voler continuare?";
  
    // // Pulsanti
    // var pulsanti = {
    //   annulla: {
    //     text: "Annulla",
    //     value: "annulla"
    //   },
    //   avanti: {
    //     text: "Avanti",
    //     value: "avanti"
    //   }
    // };
  
    // // Controlla se l'utente ha cliccato su un pulsante di submit
    // var submit_clicked = false;
    // $('button[type="submit"]').click(function(){
    //   submit_clicked = true;
    // });
  
    // // Se l'utente non ha cliccato su un pulsante di submit, mostra l'alert
    // if (!submit_clicked) {
    //   var scelta = confirm(messaggio, pulsanti);
  
    //   // Se l'utente ha cliccato su "Annulla", impedisce di lasciare la pagina
    //   if (scelta === "annulla") {
    //     if (e) {
    //       e.preventDefault(); // Per IE
    //     }
    //     return false;
    //   }
    // }
  };
  