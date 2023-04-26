<?php 

require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51N0lGVDr3X21HmBdb2IR5BRYgTClB4Amwn2nOmnER0q6mPBamqPA3cNw5yAPcFLkWBqFwbT1CB4FHJSAhMfieips00Z2rg0HIE');

$stripeSessionId = $_POST['stripeSessionId'];

try {
  $session = \Stripe\Checkout\Session::retrieve($stripeSessionId);
  $paymentIntentId = $session->payment_intent;

  $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

  if ($paymentIntent->status === 'succeeded') {
    // Le paiement a été effectué avec succès
    echo 'Le paiement a été effectué avec succès.';
  } else {
    // Le paiement a échoué
    echo 'Le paiement a échoué. Veuillez réessayer plus tard.';
  }
} catch (\Stripe\Exception\InvalidRequestException $e) {
  // Gestion des erreurs
  echo 'Une erreur est survenue. Veuillez réessayer plus tard.';
}



?>