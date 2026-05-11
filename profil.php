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
$user = $userManager->getUserById($_SESSION['user_id']);

if (!$user) {
    die("Utilisateur non trouvé.");
}

// Utilisation de la méthode métier pour l'IMC
$imc = $userManager->calculateIMC($user['poids'], $user['taille']);
?>

<div class="columns is-centered">
    <div class="column is-8">
        <div class="box has-background-dark">
            <div class="columns is-vcentered">
                <div class="column is-narrow">
                    <figure class="image is-128x128">
                        <img class="is-rounded" src="https://ui-avatars.com/api/?name=<?= urlencode($user['prenom']) ?>+<?= urlencode($user['nom']) ?>&background=ff3860&color=fff&size=128" alt="Avatar">
                    </figure>
                </div>
                <div class="column">
                    <h1 class="title is-2 mb-1"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>
                    <p class="subtitle is-5 has-text-danger">
                        <?= htmlspecialchars($user['sport_principal'] ?? 'Sport non défini') ?> • 
                        <?= htmlspecialchars($user['niveau'] ?? 'Niveau non précisé') ?>
                    </p>
                    <div class="tags">
                        <span class="tag is-light"><i class="fas fa-location-dot mr-2"></i> <?= htmlspecialchars($user['ville'] ?? 'Ville inconnue') ?></span>
                        <span class="tag is-light"><i class="fas fa-calendar mr-2"></i> Membre depuis <?= date('M Y', strtotime($user['date_inscription'])) ?></span>
                    </div>
                </div>
                
                <div class="column is-narrow">
                    <div class="buttons">
                        <a href="edit_profile.php" class="button is-danger is-outlined">
                            <i class="fas fa-edit mr-2"></i> Modifier
                        </a>
                        <a href="changer_mdp.php" class="button is-danger is-outlined">
                            <i class="fas fa-lock mr-2"></i> Sécurité
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-4">
                <div class="box has-text-centered">
                    <p class="heading">Poids</p>
                    <p class="title"><?= $user['poids'] ?> kg</p>
                </div>
            </div>
            <div class="column is-4">
                <div class="box has-text-centered">
                    <p class="heading">Taille</p>
                    <p class="title"><?= $user['taille'] ?? 0 ?> cm</p>
                </div>
            </div>
            <div class="column is-4">
                <div class="box has-text-centered">
                    <p class="heading">Expérience</p>
                    <p class="title"><?= $user['experience_annees'] ?? 0 ?> ans</p>
                </div>
            </div>
        </div>

        <div class="box">
            <h3 class="title is-4">Analyse du profil</h3>
            <div class="columns">
                <div class="column is-6">
                    <p><strong>Indice de Masse Corporelle (IMC) :</strong></p>
                    <div class="is-flex is-align-items-center mt-2">
                        <span class="title is-3 mr-4"><?= $imc ?></span>
                        <span class="tag <?= ($imc >= 18.5 && $imc <= 25) ? 'is-success' : 'is-warning' ?>">
                            <?= ($imc >= 18.5 && $imc <= 25) ? 'Poids de forme' : 'Profil à surveiller' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>