document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('#mon-formulaire');
    const searchInput = document.querySelector('#recherche');
    const suggestions = document.querySelector('#suggestions');
    const image = document.querySelector('#image');
  
    searchForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const query = searchInput.value;
      window.location.href = `element.php?q=${query}`;
    });
  
    searchInput.addEventListener('input', function() {
      const query = searchInput.value;
  
      if (query.trim().length < 2) {
        suggestions.innerHTML = '';
        return;
      } 

      if (!query.trim()) {
        suggestions.innerHTML = '';
        return
      }
      
      fetch(`autocompletion.php?q=${query}`)
        .then(response => response.json())
        .then(results => {
          suggestions.innerHTML = '';
          results.forEach(result => {
            const id = result.id;
            const name = result.name;
            const price = result.price;
            const category_id = result.category_id;
            const element = document.createElement('div');
            const link = document.createElement('a');
            //const img = document.createElement('img');
            image.src = `src/upload/${image}`;
            link.href = `product.php?id=${id}`;
            link.innerText = `${name} - ${price} € (catégorie ${category_id})`;
            element.appendChild(link);
            element.appendChild(image);
            suggestions.appendChild(element);
          });
        })
        .catch(error => {
          console.error(error);
          suggestions.innerHTML = 'Erreur de chargement des résultats.';
        });
    });
  });
