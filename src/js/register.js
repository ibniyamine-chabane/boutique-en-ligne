// Récupérer le formulaire et le bouton de soumission
const form = document.querySelector('#form-register');
const submit = document.querySelector('#submit');

// Ajouter un écouteur d'événement pour le clic sur le bouton de soumission
submit.addEventListener('click', function(event) {
  // Empêcher la soumission normale du formulaire
  event.preventDefault();

  // Récupérer les données du formulaire
  const formData = new FormData(form);

  // Envoyer les données du formulaire à un serveur via la méthode fetch
  fetch('register.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    // Vérifier si la réponse indique que l'inscription a réussi
    if (response.ok) {
      // Récupérer la réponse au format texte
      return response.text();
    } else {
      // Afficher une erreur si la réponse indique que l'inscription a échoué
      throw new Error('Erreur lors de l\'inscription');
    }
  })
  .then(contentResp => {
    // Afficher un message de réussite ou d'échec de l'inscription
    if (contentResp === 'ok') {
      alert('Inscription réussie!');
      window.location.href = 'connexion.php';
    } else {
      alert('Erreur lors de l\'inscription');
    }
  })
  .catch(error => {
    // Afficher une erreur si la requête a échoué
    console.error(error);
  });
});
