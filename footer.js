// Récupère la section principale de la page
const mainSection = document.querySelector("main");

// Définit la hauteur minimale de la section principale
const mainMinHeight = window.innerHeight - document.querySelector("header").offsetHeight - document.querySelector("footer").offsetHeight;
mainSection.style.minHeight = mainMinHeight + "px";

// Redimensionne la hauteur minimale de la section principale lorsque la fenêtre est redimensionnée
window.addEventListener("resize", () => {
    const mainMinHeight = window.innerHeight - document.querySelector("header").offsetHeight - document.querySelector("footer").offsetHeight;
    mainSection.style.minHeight = mainMinHeight + "px";
});
