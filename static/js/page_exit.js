window.onbeforeunload = function (e) {
  // Controlla se ci sono modifiche non salvate
  if (modificheNonSalvate) {
    // Mostra un avviso di conferma
    e.returnValue = "Ci sono delle modifiche non salvate. Vuoi davvero lasciare la pagina?";
  }
};
  