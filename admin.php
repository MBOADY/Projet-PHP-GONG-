<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/UserManager.php';
require_once 'classes/ClubManager.php';
include 'includes/header.php';

// 1. VÉRIFICATION DE SÉCURITÉ STRICTE
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userManager = new UserManager();
$currentUser = $userManager->getUserById($_SESSION['user_id']);

// Si l'utilisateur n'est pas admin, on le dégage !
if ($currentUser['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$clubManager = new ClubManager();
$message = '';

// 2. TRAITEMENT DES ACTIONS ADMIN (Formulaires)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Action A : Supprimer un membre
    if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {
        // On empêche l'admin de se supprimer lui-même
        if ($_POST['id_user'] != $_SESSION['user_id']) {
            $userManager->deleteUser($_POST['id_user']);
            $message = "<div class='notification is-success is-light'>L'utilisateur a été banni et supprimé avec succès.</div>";
        }
    }
    
    // Action B : Ajouter un club
    if (isset($_POST['action']) && $_POST['action'] === 'add_club') {
        $nom = $_POST['nom_club'];
        $lat = $_POST['latitude'];
        $lng = $_POST['longitude'];
        $sports = $_POST['sports'];
        
        $clubManager->addClub($nom, $lat, $lng, $sports);
        $message = "<div class='notification is-success is-light'>Le nouveau club a été ajouté à la carte !</div>";
    }
}

// Récupération des données pour l'affichage
$allUsers = $userManager->getAllUsers();
?>

<div class="columns is-centered">
    <div class="column is-11">
        
        <div class="has-text-centered mb-6 mt-4">
            <span class="icon has-text-danger is-large"><i class="fas fa-crown fa-2x"></i></span>
            <h1 class="title is-2 mt-2">Panel d'Administration</h1>
            <p class="subtitle is-5 has-text-grey">Gestion de la plateforme GONG</p>
        </div>

        <?= $message ?>

        <div class="columns is-variable is-5">
            
            <div class="column is-4">
                <div class="box" style="border-top: 4px solid #ff3860;">
                    <h2 class="title is-4"><i class="fas fa-map-pin has-text-danger mr-2"></i> Ajouter un Club</h2>
                    <p class="is-size-7 has-text-grey mb-4">Ce club apparaîtra instantanément sur la carte interactive des membres.</p>
                    
                    <form method="POST">
                        <input type="hidden" name="action" value="add_club">
                        
                        <div class="field">
                            <label class="label is-small">Nom du Club</label>
                            <input class="input" type="text" name="nom_club" placeholder="Ex: GONG Academy" required>
                        </div>
                        
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label is-small">Latitude</label>
                                    <input class="input" type="number" step="any" name="latitude" placeholder="46.3237" required>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label is-small">Longitude</label>
                                    <input class="input" type="number" step="any" name="longitude" placeholder="-0.4571" required>
                                </div>
                            </div>
                        </div>
                        <p class="is-size-7 has-text-grey mb-3"><em>Astuce : Allez sur Google Maps, clic droit sur l'endroit > copier les coordonnées.</em></p>

                        <div class="field">
                            <label class="label is-small">Sports proposés</label>
                            <input class="input" type="text" name="sports" placeholder="Ex: Boxe Anglaise, MMA, Grappling" required>
                        </div>
                        
                        <button type="submit" class="button is-danger is-fullwidth mt-4">Ajouter le club</button>
                    </form>
                </div>
            </div>

            <div class="column is-8">
                <div class="box" style="border-top: 4px solid #363636;">
                    <h2 class="title is-4"><i class="fas fa-users-cog mr-2"></i> Modération des Membres</h2>
                    
                    <div class="table-container">
                        <table class="table is-fullwidth is-striped is-hoverable">
                            <thead>
                                <tr>
                                    <th>Nom / Prénom</th>
                                    <th>Email</th>
                                    <th>Ville</th>
                                    <th>Rôle</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($allUsers as $u): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></strong></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= htmlspecialchars($u['ville']) ?></td>
                                        <td>
                                            <span class="tag <?= $u['role'] === 'admin' ? 'is-danger' : 'is-dark' ?>">
                                                <?= strtoupper($u['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($u['id_utilisateur'] != $_SESSION['user_id']): ?>
                                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir bannir ce membre définitivement ?');">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="id_user" value="<?= $u['id_utilisateur'] ?>">
                                                    <button type="submit" class="button is-small is-danger is-outlined" title="Bannir le membre">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="is-size-7 has-text-grey">Vous-même</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>