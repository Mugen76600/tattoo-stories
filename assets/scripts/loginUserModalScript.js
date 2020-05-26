$(function () {
    // Maintient la modal de login ouverte en cas de formulaire mal rempli
    if ($("#logModal").hasClass("show")) {
        $("#logModal").modal("show");
    }
})