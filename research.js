  document.addEventListener('DOMContentLoaded', function() {
    const search = document.querySelector('#recherche');
    const suggestions = document.querySelector('#suggestions');

    search.addEventListener('keyup', function() {
      const query = search.value;

      if (query !== '') {
        fetch(`autocompletion.php?q=${query}`)
          .then(response => response.json())
          .then(data => {
            suggestions.innerHTML = '';
            data.forEach(suggestion => {
              const div = document.createElement('div');
              div.textContent = suggestion;
              div.addEventListener('click', function() {
                search.value = suggestion;
                suggestions.innerHTML = '';
              });
              suggestions.appendChild(div);
            });
          });
      } else {
        suggestions.innerHTML = '';
      }
    });
  });



