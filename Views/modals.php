<!-- Bouton modal login -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#logModal"></button> -->

<!-- Modal de login -->
<div class="modal fade <?= isset($loginModalError) ? "show" : "" ?>" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="logModalTitle">Connexion à votre compte Tattoo <span class="text-body">Stories</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modalLogin">Identifiant</label>
                        <input type="text" class="form-control <?= isset($loginModalError['modalLogin']) ? "is-invalid" : "" ?>" name="modalLogin" id="modalLogin" value="<?= isset($_POST['modalLogin']) ? $_POST['modalLogin'] : "" ?>" placeholder="Votre identifiant" />
                        <small class="form-text text-muted">Pseudonyme ou adresse mail</small>
                        <small class="text-danger"><?= isset($loginModalError['modalLogin']) ? $loginModalError['modalLogin'] : "" ?></small>
                    </div>
                    <div class="form-group">
                        <label for="modalPassword">Mot de passe</label>
                        <input type="password" class="form-control <?= isset($loginModalError['modalPassword']) ? "is-invalid" : "" ?>" name="modalPassword" id="modalPassword" placeholder="Votre mot de passe" />
                        <small class="text-danger"><?= isset($loginModalError['modalPassword']) ? $loginModalError['modalPassword'] : "" ?></small>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="checkbox" id="checkbox" />
                        <label class="custom-control-label" for="checkbox">Se souvenir de moi</label>
                    </div>
                </div>
                <!-- Message d'erreur si login et le password ne correspondent pas -->
                <?php if (isset($loginModalError['modalLog'])) { ?>
                    <p class="text-danger text-center">
                        <?= $loginModalError['modalLog'] ?>
                    </p>
                <?php } ?>
                <a href="/Views/addUser.php" class="text-decoration-none text-danger ml-3">Pas encore inscrit&#8226e ? C'est par ici !</a>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" name="connectUser" class="btn btn-danger">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bouton modal mentions légales -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#legalModal"></button> -->

<!-- Modal des mentions légales -->
<div class="modal fade" id="legalModal" tabindex="-1" role="dialog" aria-labelledby="legalModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="legalModalTitle">Mentions légales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>
                    <span class="text-danger">Identification de l'éditeur</span></br>
                    Tattoo Stories - 2, rue Dombasle 76600 Le Havre</br></br>

                    Standard : 01 21 54 75 00</br></br>

                    N° SIREN : 130-009-181</br></br>

                    N° SIRET : 130-009-186 00031</br></br>

                    Code APE : 5823Z</br></br>

                    <span class="text-danger">Directeur de la publication</span></br>
                    «Au sens de l'article 93-2 de la loi n° 82-652 du 29 juillet 1982»</br></br>

                    Monsieur HOCHART Alexandre, directeur de Tattoo Stories.</br></br>

                    <span class="text-danger">Prestataire d'hébergement</span></br>
                    Pour tattoostories.com</br></br>

                    Mattos Worldline River West Coast</br></br>

                    80 quai Gruaud</br></br>

                    95877 Beuzons Cedex</br></br>

                    Tél : +33 (0)1 34 34 95 67</br></br>

                    Fax : +33 (0)1 73 26 00 11</br></br>

                    <span class="text-danger">Traitement des données à caractère personnel</span></br>
                    tattoostories.com a fait l'objet d'une déclaration à la Commission Nationale de l'Informatique et des Libertés (CNIL) sous le n° 712957.</br></br>

                    La base de données diffusée dans la rubrique Annuaire de l'administration a fait l'objet d'une déclaration spécifique sous le n° 1546654.</br></br>

                    L'annuaire de l'administration a été autorisé par l'arrêté du 6 novembre 2000 relatif à la création d'un site sur internet intitulé tattoostories.com (modifié par l'arrêté du 10 août 2001).</br></br>

                    Conformément aux dispositions de la loi n° 78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés, vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données qui vous concernent. Pour demander une modification, rectification ou suppression des données vous concernant, il vous suffit d'envoyer un courrier par voie électronique ou postale à Tattoo Stories en justifiant de votre identité.</br></br>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Bouton modal image obligatoire -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mandatoryPicModal"></button> -->

<!-- Modal image obligatoire -->
<div class="modal fade" id="mandatoryPicModal" tabindex="-1" role="dialog" aria-labelledby="mandatoryPicModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered justify-content-center" role="document">
        <div>
            <img class="img-fluid" src="<?= $value[2] ?>" alt="Principale image du tattoo" />
        </div>
    </div>
</div>

<!-- Bouton modal image optionnelle 1 -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pic1Modal"></button> -->

<!-- Modal image optionnelle 1 -->
<div class="modal fade" id="pic1Modal" tabindex="-1" role="dialog" aria-labelledby="pic1ModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered justify-content-center" role="document">
        <div>
            <img class="img-fluid" src="<?= $value[3] ?>" alt="Autre image du tattoo" />
        </div>
    </div>
</div>

<!-- Bouton modal image optionnelle 2 -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pic2Modal"></button> -->

<!-- Modal image optionnelle 2 -->
<div class="modal fade" id="pic2Modal" tabindex="-1" role="dialog" aria-labelledby="pic2ModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered justify-content-center" role="document">
        <div>
            <img class="img-fluid" src="<?= $value[4] ?>" alt="Autre image du tattoo" />
        </div>
    </div>
</div>

<!-- Modal de déconnexion utilisateur -->
<div class="modal fade" id="deconnectUserModal" tabindex="-1" role="dialog" aria-labelledby="deconnectUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deconnectUserModalLabel">Confirmation de la <span class="text-body">déconnexion</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment vous déconnecter ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                <form action="" method="POST"><button class="btn btn-danger" type="submit" name="disconnect">Déconnexion</button></form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression utilisateur -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteUserModalLabel">Confirmation de la <span class="text-body">suppression</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer votre compte ? Vos stories et vos commentaires diparaîtront.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                <form action="" method="POST"><button class="btn btn-danger" type="submit" name="deleteUser">Suppression</button></form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression commentaire -->
<div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteCommentModalLabel">Confirmation de la <span class="text-body">suppression</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer ce commentaire ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">En fait non...</button>
                <form action="" method="POST"><button class="btn btn-danger" type="submit" name="deleteComment">Suppression</button></form>
            </div>
        </div>
    </div>
</div>