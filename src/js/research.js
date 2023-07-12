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
            const img = result.image;
            const category_id = result.category_id;
            const category = result.category_name;
            const box_search = document.createElement('div');
            const link = document.createElement('a');
            const image = document.createElement('img');
            box_search.className = 'result-box';
            image.className = 'img-search'; 
            image.src = `src/upload/${img}`;
            link.href = `product.php?id=${id}`;
            console.log(result);
            box_search.appendChild(image);
            link.innerText = `${name} - ${price} € (catégorie : ${category})`;
            box_search.appendChild(link);
            suggestions.appendChild(box_search);
          });
        })
        .catch(error => {
          console.error(error);
          suggestions.innerHTML = 'Erreur de chargement des résultats.';
        });
    });
  });