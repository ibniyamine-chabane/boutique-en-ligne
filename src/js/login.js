const xhr = new XMLHttpRequest();
xhr.open("POST", "login.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log(response);
            if (response.success) {
                alert("Vous êtes inscrit !");
                window.location.replace('index.php');
            } else {
                alert(response.message);
            }
        } else {
            console.error("Erreur lors de l'envoi du formulaire:", xhr.statusText);
        }
    }
};
xhr.send(formData);
