// Attendre le chargement complet de la page avant d'exécuter le script
window.addEventListener("load", function() {
  
    // Sélectionner l'élément du footer et du corps de la page
    const footer = document.querySelector("footer");
    const body = document.querySelector("body");
    
    // Calculer la hauteur du corps de la page et du footer
    const bodyHeight = body.offsetHeight;
    const footerHeight = footer.offsetHeight;
    
    // Vérifier si le corps de la page est plus petit que la hauteur de la fenêtre
    if (bodyHeight < window.innerHeight) {
      // Si c'est le cas, positionner le footer en bas de la page
      footer.style.position = "absolute";
      footer.style.bottom = "0";
    }
  });
  