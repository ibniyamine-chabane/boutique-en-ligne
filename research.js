document.addEventListener('DOMContentLoaded', function() {
    const search = document.querySelector('#recherche');
    const suggestions = document.querySelector('#suggestions');
  
    search.addEventListener('input', function() {
      const query = search.value;
  
      if (query.trim().length < 0) {
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
            const category_id = result.category_id;
            const element = document.createElement('div');
            const link = document.createElement('a');
            link.href = `product.php?id=${id}`;
            link.innerText = `${name} - ${price} € (catégorie ${category_id})`;
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
  