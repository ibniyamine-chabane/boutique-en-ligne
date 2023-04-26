// Vérifier la validité de la carte de crédit avant la soumission du formulaire
const form = document.getElementById('payment-form');
form.addEventListener('submit', (event) => {
  event.preventDefault();
  
  const cardNumber = document.getElementById('card-number').value;
  const cardExpiry = document.getElementById('card-expiry').value;
  const cardCvc = document.getElementById('card-cvc').value;

  // Créer un jeton de carte à l'aide de la bibliothèque Stripe
  const stripe = Stripe('pk_test_51N0lGVDr3X21HmBd8Nt0wp3Ycl4fEHvBypYB3az5A05jsYlQX3hPTkYsUHHdYzwCpftybkuGS5sSjllgxK1kTU7L00KPLgLD4z');
  const card = {
    number: cardNumber,
    exp_month: cardExpiry.split('/')[0],
    exp_year: cardExpiry.split('/')[1],
    cvc: cardCvc
  };
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Si la carte de crédit est invalide, afficher un message d'erreur
      alert('La carte de crédit est invalide : ' + result.error.message);
    } else {
      // Si la carte de crédit est valide, passer la commande
      // Votre code de traitement de commande ici...
      alert('La carte de crédit est valide. La commande a été passée.');
    }
  });
});
