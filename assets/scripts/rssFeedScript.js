$(function () {
    // Titre de l'onglet
    document.title += " - Articles";
    // Affichage d'ombre au passage de la souris
    $(".storiesCards").hover(function () {
        // Souris sur l'élément
        $(this).addClass("shadow");
    }, function () {
        // Souris hors de l'élément
        $(this).removeClass("shadow");
    });
})