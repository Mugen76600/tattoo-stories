$(function () {
    // Maintient la modal de modification user ouverte en cas de formulaire mal rempli
    if ($("#updateUserModal").hasClass("show")) {
        $("#updateUserModal").modal("show");
    }
})