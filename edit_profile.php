<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/UserManager.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userManager = new UserManager();
$user_id = $_SESSION['user_id'];
$success = null;
$error = null;

// 1. Récupérer les infos
$user = $userManager->getUserById($user_id);

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $ville = $_POST['ville'];
    $poids = $_POST['poids'];
    $taille = $_POST['taille'];
    $sport = $_POST['sport'];
    $niveau = $_POST['niveau'];
    $experience = $_POST['experience'];

    // Appel de la méthode de mise à jour
    if ($userManager->updateProfile($user_id, $prenom, $nom, $ville, $poids, $taille, $sport, $niveau, $experience)) {
        $_SESSION['prenom'] = $prenom; // MAJ de la session pour le header
        $success = "Votre profil a été mis à jour avec succès !";
        header("Refresh:1; url=profil.php"); 
    } else {
        $error = "Erreur lors de la mise à jour.";
    }
}
?>

<div class="columns is-centered">
    <div class="column is-6">
        <div class="box mt-5" style="border-top: 4px solid #ff3860;">
            <div class="has-text-centered mb-5">
                <span class="icon has-text-danger is-large"><i class="fas fa-user-edit fa-2x"></i></span>
                <h1 class="title is-4 mt-2">Modifier mes informations</h1>
            </div>

            <?php if ($success): ?><div class="notification is-success is-light"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="notification is-danger is-light"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Prénom</label>
                            <input class="input" type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Nom</label>
                            <input class="input" type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Ville</label>
                    <input class="input" type="text" name="ville" value="<?= htmlspecialchars($user['ville']) ?>" required>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Poids (kg)</label>
                            <input class="input" type="number" name="poids" value="<?= $user['poids'] ?>" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Taille (cm)</label>
                            <input class="input" type="number" name="taille" value="<?= $user['taille'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Sport Principal</label>
                    <input class="input" name="sport" list="sports-list" value="<?= htmlspecialchars($user['sport_principal']) ?>" required>
                   <datalist id="sports-list">
                    <option value="MMA"><option value="Boxe Anglaise"><option value="Muay Thaï"><option value="Kickboxing">
                    <option value="Jiu-Jitsu Brésilien"><option value="Lutte"><option value="Judo"><option value="Karaté">
                    <option value="Savate"><option value="Sambo"><option value="Grappling"><option value="Krav Maga">
                    <option value="Taekwondo"><option value="Luta Livre"><option value="Aïkido"><option value="Kendo"><option value="Sanda">
                </datalist>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Niveau actuel</label>
                            <div class="select is-fullwidth">
                                <select name="niveau">
                                    <option value="Débutant" <?= $user['niveau'] == 'Débutant' ? 'selected' : '' ?>>Débutant</option>
                                    <option value="Intermédiaire" <?= $user['niveau'] == 'Intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
                                    <option value="Avancé" <?= $user['niveau'] == 'Avancé' ? 'selected' : '' ?>>Avancé</option>
                                    <option value="Compétiteur" <?= $user['niveau'] == 'Compétiteur' ? 'selected' : '' ?>>Compétiteur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Expérience (années)</label>
                            <input class="input" type="number" name="experience" value="<?= $user['experience_annees'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="field mt-5">
                    <button class="button is-danger is-fullwidth">Enregistrer les modifications</button>
                    <a href="profil.php" class="button is-light is-fullwidth mt-2">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>