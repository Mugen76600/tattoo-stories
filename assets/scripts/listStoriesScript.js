$(function () {
    // Récupération de l'url de la page
    var url = window.location.href;
    // Adapte le titre de l'onglet selon qu'une recherche soit effectuée ou non
    if (url.indexOf("?query=") != -1) {
        document.title += " - Résultat recherche";
    } else {
        document.title += " - Liste stories";
    }
    // Affichage d'ombre au passage de la souris
    $(".storiesCards").hover(function () {
        // Souris sur l'élément
        $(this).addClass("shadow");
    }, function () {
        // Souris hors de l'élément
        $(this).removeClass("shadow");
    });
})