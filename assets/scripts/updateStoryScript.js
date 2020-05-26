$(function () {
    // Titre de l'onglet
    document.title += " - Modification de story";
    // Au clic, affiche une image placeholder pour alerter l'utilisateur que l'input est vide
    $("#cancelPic2").click(function () {
        $("#thumbnail2").attr("src", "/assets/img/placeholder.png");
        $("#bufferInputPic2").val("deletedImage");
    })
    $("#cancelPic3").click(function () {
        $("#thumbnail3").attr("src", "/assets/img/placeholder.png");
        $("#bufferInputPic3").val("deletedImage");
    })
    // Aperçu de l'image pour l'update de la première image
    $("#picture1").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
    // Aperçu de l'image pour l'update de la deuxième image
    $("#picture2").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
    // Aperçu de l'image pour l'update de la troisième image
    $("#picture3").change(function () {
        var input = $(this);
        var oFReader = new FileReader();
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        };
    })
})