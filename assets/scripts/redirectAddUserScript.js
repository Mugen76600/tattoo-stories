$(function () {
    // Titre de l'onglet
    document.title += " - Redirection";
    // Effectue une redirection sur l'index après 3 secondes
    setTimeout(function () {
        window.location = "/index.php";
    }, 3000);
})