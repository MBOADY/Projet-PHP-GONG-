<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/SparringManager.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$my_id = $_SESSION['user_id'];

$sparringManager = new SparringManager();
$demandesRecues = $sparringManager->getReceivedRequests($my_id);
$demandesEnvoyees = $sparringManager->getSentRequests($my_id);
?>
<h1 class="title">Mes Notifications</h1>
<div class="columns">
    <div class="column is-6">
        <h2 class="subtitle">Demandes reçues</h2>
        <?php foreach($demandesRecues as $req): ?>
            <div class="box">
                <p><strong><?= htmlspecialchars($req['prenom']) ?></strong> (<?= $req['sport_principal'] ?>) veut un sparring.</p>
                <?php if($req['statut'] == 'En attente'): ?>
                    <form action="action_sparring.php" method="POST" class="mt-2">
                        <input type="hidden" name="id_session" value="<?= $req['id_session'] ?>">
                        <button name="action" value="Accepté" class="button is-success is-small">Accepter</button>
                        <button name="action" value="Refusé" class="button is-danger is-small">Refuser</button>
                    </form>
                <?php else: ?>
                    <span class="tag mt-2 <?= $req['statut'] == 'Accepté' ? 'is-success' : 'is-danger' ?>"><?= $req['statut'] ?></span>
                    <?php if($req['statut'] == 'Accepté'): ?>
                        <a href="chat.php?contact_id=<?= $req['id_demandeur'] ?>" class="button is-link is-small ml-2">Message</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="column is-6">
        <h2 class="subtitle">Demandes envoyées</h2>
        <?php foreach($demandesEnvoyees as $req): ?>
            <div class="box">
                <p>À <strong><?= htmlspecialchars($req['prenom']) ?></strong> : 
                <span class="tag <?= $req['statut'] == 'Accepté' ? 'is-success' : 'is-warning' ?>"><?= $req['statut'] ?></span></p>
                <?php if($req['statut'] == 'Accepté'): ?>
                    <a href="chat.php?contact_id=<?= $req['id_partenaire'] ?>" class="button is-link is-small">Discuter</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>