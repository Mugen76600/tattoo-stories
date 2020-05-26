<?php
if (!isset($_COOKIE['acceptedCookies'])) { ?>
    <form action="" method="POST">
        <div class="row rounded-0 align-items-center m-0 py-0 alert alert-info alert-dismissible fade show fixed-bottom" role="alert">
            <div class="col-12 col-md-6">
                <small>
                    <strong>AVERTISSEMENT</strong> Ce site utilise des cookies pour améliorer l'expérience de l'utilisateur. Aucune donnée n'est utilisée à des fins commerciales.
                </small>
            </div>
            <div class="col-12 col-md-6">
                <button type="submit" name="agreeCookies" class="my-2 btn btn-sm btn-outline-info">J'ACCEPTE</button>
                <a target="_blank" href="https://www.cnil.fr/fr/reglement-europeen-protection-donnees" class="ml-3 text-decoration-none text-info">En savoir plus</a>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </form>
<?php } ?>