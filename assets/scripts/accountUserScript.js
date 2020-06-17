$(function () {
    // Titre de l'onglet
    document.title += " - Mon compte";
    // Affichage d'ombre au passage de la souris
    $(".storiesCards").hover(function () {
        // Souris sur l'élément
        $(this).addClass("shadow");
    }, function () {
        // Souris hors de l'élément
        $(this).removeClass("shadow");
    });
    // Activation des tooltips
    $('[data-toggle="tooltip"]').tooltip();
})