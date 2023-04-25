let message = document.querySelector('#message');
let quantity = document.querySelector('#quantity');

if (quantity = NaN) {
    alert('vous devez entre les quantités en nombre');
}

document.querySelector('#form-add-cart').addEventListener('submit', () => {

    message.textContent = "votre produit a bien été ajouté à votre panier";
       
        setTimeout(function() {
            message.textContent = "";
          }, 2000)      

});