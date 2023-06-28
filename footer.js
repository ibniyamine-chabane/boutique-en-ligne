<<<<<<< Updated upstream
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
  
=======
function setFooterPosition() {
  const body = document.body;
  const html = document.documentElement;
  const footer = document.querySelector('footer');

  const bodyHeight = Math.max(body.scrollHeight, body.offsetHeight);
  const htmlHeight = Math.max(html.scrollHeight, html.offsetHeight);
  const windowHeight = window.innerHeight;

  if (bodyHeight < windowHeight) {
    footer.style.position = 'fixed';
    footer.style.bottom = '0';
    footer.style.left = '0';
    footer.style.width = '100%';
  } else {
    footer.style.position = 'relative';
  }
}

window.addEventListener('load', setFooterPosition);
window.addEventListener('resize', setFooterPosition);
>>>>>>> Stashed changes
