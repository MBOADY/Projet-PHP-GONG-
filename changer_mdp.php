<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/UserManager.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ancien_mdp = $_POST['ancien_mdp'];
    $nouveau_mdp = $_POST['nouveau_mdp'];
    $confirm_mdp = $_POST['confirm_mdp'];

    $user = $userManager->getUserById($_SESSION['user_id']);

    if (!password_verify($ancien_mdp, $user['mot_de_passe'])) {
        $erreur = "L'ancien mot de passe est incorrect.";
    } elseif ($nouveau_mdp !== $confirm_mdp) {
        $erreur = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        $userManager->changePassword($_SESSION['user_id'], $nouveau_mdp);
        $succes = "Votre mot de passe a été modifié avec succès !";
    }
}
?>

<div class="columns is-centered">
    <div class="column is-half is-one-third-widescreen">
        <div class="box mt-6" style="border-top: 4px solid #ff3860;">
            <div class="has-text-centered mb-5">
                <span class="icon has-text-danger is-large"><i class="fas fa-lock fa-2x"></i></span>
                <h2 class="title is-4 mt-2">Changer de mot de passe</h2>
            </div>
            
            <?php if(isset($erreur)) echo "<div class='notification is-danger is-light'>$erreur</div>"; ?>
            <?php if(isset($succes)) echo "<div class='notification is-success is-light'>$succes</div>"; ?>

            <form method="POST">
                <div class="field">
                    <label class="label">Mot de passe actuel</label>
                    <div class="control">
                        <input class="input" type="password" name="ancien_mdp" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Nouveau mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="nouveau_mdp" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Confirmer le nouveau mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="confirm_mdp" required>
                    </div>
                </div>

                <div class="field mt-5">
                    <div class="control">
                        <button type="submit" class="button is-danger is-fullwidth">Mettre à jour</button>
                    </div>
                </div>
                
                <div class="has-text-centered mt-4">
                    <a href="profil.php" class="has-text-grey">Retour au profil</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>