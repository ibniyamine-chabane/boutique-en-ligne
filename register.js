document.getElementById("formulaire").addEventListener("submit", async function (e) {
  e.preventDefault();

  const formData = new FormData(e.target);
  formData.append("submit", "true"); // Ajout d'une entrée "submit" aux données du formulaire

  const response = await fetch("register.action.php", {
      method: "POST",
      body: formData
  });

  if (response.ok) {
      const result = await response.json();
      console.log(result);

      if (result.success) {
          alert("Vous êtes inscrit !");
      } else {
          alert(result.message);
      }
  } else {
      console.error("Erreur lors de l'envoi du formulaire:", response.statusText);
  }
});
