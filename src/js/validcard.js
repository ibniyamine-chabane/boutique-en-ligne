        // Récupérer le numéro de commande depuis le sessionStorage
        let orderNumber = sessionStorage.getItem('orderNumber');

        // Vérifier si le numéro de commande existe
        if (orderNumber) {
            // Convertir le numéro de commande en entier
            orderNumber = parseInt(orderNumber);
        } else {
            // Si le numéro de commande n'existe pas, initialiser à 1
            orderNumber = 1;
        }

        // Afficher le numéro de commande
        document.getElementById('order-number').textContent = orderNumber;

        // Incrémenter le numéro de commande pour la prochaine commande
        orderNumber++;

        // Enregistrer le nouveau numéro de commande dans le sessionStorage
        sessionStorage.setItem('orderNumber', orderNumber.toString());