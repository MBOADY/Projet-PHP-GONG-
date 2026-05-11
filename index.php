<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/UserManager.php';
include 'includes/header.php';

// 1. Redirection si l'utilisateur n'est pas connecté
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userManager = new UserManager();
$user_id = $_SESSION['user_id'];

// 2. Récupération des informations de l'utilisateur connecté (pour le matchmaking)
$currentUser = $userManager->getUserById($user_id);

// 3. Récupération des filtres de recherche via l'URL (méthode GET)
$search_ville = $_GET['search_ville'] ?? '';
$search_sport = $_GET['search_sport'] ?? '';

// 4. Logique d'affichage : Recherche spécifique OU Matchmaking par défaut
if (!empty($search_ville) || !empty($search_sport)) {
    // Si l'utilisateur a rempli le formulaire de recherche
    $partenaires = $userManager->searchUsers($user_id, $search_ville, $search_sport);
    $titre_section = "Résultats de votre recherche";
} else {
    // Par défaut : Affichage des 6 profils les plus pertinents
    // On utilise le sport, la ville et le poids du profil connecté
    $partenaires = $userManager->getBestMatches(
        $user_id, 
        $currentUser['sport_principal'] ?? '', 
        $currentUser['ville'] ?? '', 
        $currentUser['poids'] ?? 0
    );
    $titre_section = "Matchmaking : Profils recommandés pour vous";
}
?>

<div class="columns is-centered">
    <div class="column is-10">
        <div class="has-text-centered mb-6 mt-4">
            <h1 class="title is-2">Trouvez votre partenaire de Sparring</h1>
            <p class="subtitle is-5 has-text-grey">Recherchez par ville ou par sport</p>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="notification is-success is-light has-text-centered mb-5">
                <button class="delete"></button>
                Votre proposition de sparring a bien été envoyée !
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error']) && $_GET['error'] == 'limite'): ?>
            <div class="notification is-danger is-light has-text-centered mb-5">
                <button class="delete"></button>
                <strong>Action refusée :</strong> Vous ne pouvez pas envoyer plus de 2 demandes de sparring à cette même personne.
            </div>
        <?php endif; ?>

        <form method="GET" action="index.php" class="box mb-6">
            <div class="columns is-vcentered">
                <div class="column is-4">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="search_ville" placeholder="Ville (ex: Niort)" value="<?= htmlspecialchars($search_ville) ?>">
                            <span class="icon is-small is-left"><i class="fas fa-location-dot"></i></span>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="search_sport" list="sports-list" placeholder="Sport (ex: MMA)" value="<?= htmlspecialchars($search_sport) ?>">
                            <span class="icon is-small is-left"><i class="fas fa-hand-fist"></i></span>
                            
                            <datalist id="sports-list">
                                <option value="MMA"><option value="Boxe Anglaise"><option value="Muay Thaï"><option value="Kickboxing">
                                <option value="Jiu-Jitsu Brésilien"><option value="Lutte"><option value="Judo"><option value="Karaté">
                                <option value="Savate"><option value="Sambo"><option value="Grappling"><option value="Krav Maga">
                                <option value="Taekwondo"><option value="Luta Livre"><option value="Aïkido"><option value="Kendo"><option value="Sanda">
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <button type="submit" class="button is-danger is-fullwidth">
                        <i class="fas fa-search mr-2"></i> Rechercher
                    </button>
                </div>
            </div>
        </form>

        <h2 class="title is-4 mb-5"><i class="fas fa-users has-text-danger mr-2"></i> <?= $titre_section ?></h2>

        <div class="columns is-multiline">
            <?php if (count($partenaires) > 0): ?>
                <?php foreach ($partenaires as $p): ?>
                    <div class="column is-4">
                        <div class="box h-100 is-flex is-flex-direction-column">
                            <div class="is-flex is-align-items-center mb-4">
                                <figure class="image is-48x48 mr-3">
                                    <img class="is-rounded" src="https://ui-avatars.com/api/?name=<?= urlencode($p['prenom'] ?? '') ?>+<?= urlencode($p['nom'] ?? '') ?>&background=333&color=fff" alt="Avatar">
                                </figure>
                                <div>
                                    <p class="title is-5 mb-0"><?= htmlspecialchars(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? '')) ?></p>
                                    <p class="subtitle is-7 has-text-danger"><?= htmlspecialchars($p['sport_principal'] ?? 'Sport non défini') ?></p>
                                </div>
                            </div>
                            
                            <div class="content is-small" style="flex-grow: 1;">
                                <p>
                                    <i class="fas fa-location-dot mr-2"></i> <?= htmlspecialchars($p['ville'] ?? 'Ville inconnue') ?><br>
                                    <i class="fas fa-weight-hanging mr-2"></i> <?= $p['poids'] ?? '?' ?> kg<br>
                                    <i class="fas fa-medal mr-2"></i> <?= htmlspecialchars($p['niveau'] ?? 'Niveau non précisé') ?> (<?= $p['experience_annees'] ?? '0' ?> ans)
                                </p>
                            </div>
                            
                            <form action="proposer_sparring.php" method="POST" class="mt-3">
                                <input type="hidden" name="id_partenaire" value="<?= $p['id_utilisateur'] ?>">
                                <button type="submit" class="button is-danger is-outlined is-fullwidth is-small">
                                    <i class="fas fa-handshake mr-2"></i> Proposer un sparring
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="column is-12">
                    <div class="notification is-warning is-light has-text-centered">
                        Aucun partenaire trouvé. Essayez de modifier vos critères de recherche !
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>