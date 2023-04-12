document.addEventListener('DOMContentLoaded', function() {
    const searchQuery = document.querySelector('#search-query');
    const products = document.querySelector('#products');

    // Récupération de la chaîne de recherche depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('q');
    searchQuery.innerText = query;

    // Récupération des produits correspondant à la chaîne de recherche
    fetch(`autocompletion.php?q=${query}`)
        .then(response => response.json())
        .then(results => {
            if (results.length === 0) {
                // Aucun produit trouvé
                products.innerHTML = "<p>Aucun produit avec ce nom.</p>";
            } else {
                // Affichage des produits correspondant à la recherche
                results.forEach(result => {
                    const id = result.id;
                    const nom = result.name;
                    const category = result.id_category;
                    const price = result.price;
                    const productDiv = document.createElement('div');
                    const productName = document.createElement('h2');
                    const productCategory = document.createElement('p');
                    const productPrice = document.createElement('p');
                    const productLink = document.createElement('a');

                    productName.innerText = nom;
                    productCategory.innerText = `Catégorie : ${category}`;
                    productPrice.innerText = `Prix : ${price} €`;
                    productLink.href = `product.php?id=${id}`;
                    productLink.innerText = 'Voir le produit';

                    productDiv.appendChild(productName);
                    productDiv.appendChild(productCategory);
                    productDiv.appendChild(productPrice);
                    productDiv.appendChild(productLink);
                    products.appendChild(productDiv);
                });
            }
        })
        .catch(error => {
            console.error(error);
            products.innerHTML = "<p>Erreur de chargement des résultats.</p>";
        });
});
  
  