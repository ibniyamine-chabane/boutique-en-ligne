let profil = document.querySelector("#profil")
let message = document.querySelector("#msg")
inscription.addEventListener("click", () => {

fetch('profil.php')
    .then(response => {
        return response.text();
    })
    .then(form => {
        div.innerHTML = form;
        let submit = document.querySelector("#submit-form");
        let profilForm = document.querySelector('#profil-form');

        submit.addEventListener("click", (e) => {

            e.preventDefault();
            let formProfil = new FormData(profilForm);
            fetch("profil.php", {
                method: "POST",
                body: formProfil
            })
                .then(response => {
                    return response;
                })
        })
    })


})
