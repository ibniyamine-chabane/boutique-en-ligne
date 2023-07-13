const registerForm = document.getElementById("register-form");

registerForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  const formData = new FormData(registerForm);
  formData.append("submit", "true");

  try {
    const response = await fetch("register.php", {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      const result = await response.json();
      console.log(result);

      if (result.success) {
        alert("Vous êtes inscrit !");
        window.location.replace("login.php");
      } else {
        alert(result.message);
      }
    } else {
      console.error("Erreur lors de l'envoi du formulaire:", response.statusText);
    }
  } catch (error) {
    console.error("Erreur lors de l'envoi du formulaire:", error);
  }
});
