$(function () {
    // Titre de l'onglet
    document.title += " - Création de story";
    // Au clic, vide l'input correspondant
    $("#cancelPic1").click(function () {
        $("#picture1").val("");
    })
    $("#cancelPic2").click(function () {
        $("#picture2").val("");
    })
    $("#cancelPic3").click(function () {
        $("#picture3").val("");
    })
    // Aperçu de l'image pour l'upload de la première image
    $("#picture1").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
    // Aperçu de l'image pour l'upload de la deuxième image
    $("#picture2").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
    // Aperçu de l'image pour l'upload de la troisième image
    $("#picture3").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
})