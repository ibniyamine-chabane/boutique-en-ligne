function validatecreditcard() {
  var creditCardNumber = document.getElementById("number_entered").value;
  var validateLabel = document.getElementById("validate");

  // Supprimez les espaces et les tirets du numéro de carte
  var strippedNumber = creditCardNumber.replace(/[\s-]/g, "");

  // Vérifiez si le numéro de carte est vide ou contient des caractères non numériques
  if (strippedNumber === "" || /\D/.test(strippedNumber)) {
    validateLabel.textContent = "Numéro de carte de crédit invalide";
    return;
  }

  // Vérifiez la validité du numéro de carte en utilisant l'algorithme de Luhn
  var sum = 0;
  var shouldDouble = false;
  for (var i = strippedNumber.length - 1; i >= 0; i--) {
    var digit = parseInt(strippedNumber.charAt(i), 10);
    if (shouldDouble) {
      digit *= 2;
      if (digit > 9) {
        digit -= 9;
      }
    }
    sum += digit;
    shouldDouble = !shouldDouble;
  }

  if (sum % 10 === 0) {
    validateLabel.textContent = "Numéro de carte de crédit valide";
  } else {
    validateLabel.textContent = "Numéro de carte de crédit invalide";
  }
}
