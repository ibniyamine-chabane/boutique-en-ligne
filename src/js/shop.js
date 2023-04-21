
document.querySelector('#filter_form').addEventListener('submit', (event) => {
    event.preventDefault(); // Empêche le rechargement de la page
  
    // Récupération des données du formulaire
    const formData = new FormData(event.target);
  
    // Envoi de la requête
    fetch('shop.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      // Redirection vers la page 
      alert('toto')
      window.location.replace("shop.php");
    })
    .catch(error => {
      console.error(error);
    });
  });