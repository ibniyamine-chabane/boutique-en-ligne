document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#mon-formulaire');
    const search = form.querySelector('#recherche');
    const suggestions = document.querySelector('#suggestions');
  
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      const query = search.value.trim();
      if (query.length < 0) {
        alert('La requête de recherche doit contenir au moins 2 caractères.');
        return;
      }
      const url = `element.php?q=${query}`;
      window.location.href = url;
    });
  
    search.addEventListener('input', function() {
      const query = search.value.trim();
  
      if (query.length < 0) {
        suggestions.innerHTML = '';
        return;
      }
  
      fetch(`autocompletion.php?q=${query}`)
        .then(response => response.json())
        .then(results => {
          suggestions.innerHTML = '';
          results.forEach(result => {
            const id = result.id;
            const name = result.name;
            const price = result.price;
            const imageUrl = result.image_url;
            const element = document.createElement('div');
            const link = document.createElement('a');
            const image = document.createElement('img');
            link.href = `product.php?id=${id}`;
            image.src = imageUrl;
            image.style.width = '50px'; // ajuster la taille de l'image
            link.innerText = `${name} - ${price} €`;
            element.appendChild(image);
            element.appendChild(link);
            suggestions.appendChild(element);
          });
        })
        .catch(error => {
          console.error(error);
          suggestions.innerHTML = 'Erreur de chargement des résultats.';
        });
    });
  });
  