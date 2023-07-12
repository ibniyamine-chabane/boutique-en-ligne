document.getElementById("register-form").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.append("submit", "true");

    const response = await fetch("register.php", {
        method: "POST",
        body: formData,
        headers: {
            "Content-Type": "text/html; charset=UTF-8"
        }
    });

    if (response.ok) {
        try {
            const result = await response.json();
            console.log(result);

            if (result.success) {
                alert("Vous êtes inscrit !");
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error("Erreur lors de l'analyse de la réponse JSON:", error);
        }
    } else {
        console.error("Erreur lors de l'envoi du formulaire:", response.statusText);
    }
});
