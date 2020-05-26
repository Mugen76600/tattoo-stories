$(function () {
    // Titre de l'onglet
    document.title += " - Détail story";
    // Maintient la carte de commentaire ouverte en cas de formulaire mal rempli
    if ($("#commentForm").hasClass("error")) {
        $("#commentForm").collapse("show");
    }
    // Maintient la modal de modification de commentaire ouverte en cas de formulaire mal rempli
    if ($("#updateCommentModal").hasClass("show")) {
        $("#updateCommentModal").modal("show");
    }
})