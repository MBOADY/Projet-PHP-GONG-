<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/SparringManager.php';
include 'includes/header.php';

// Sécurité
if (!isset($_SESSION['user_id']) || !isset($_GET['contact_id'])) {
    header("Location: index.php");
    exit();
}

$my_id = $_SESSION['user_id'];
$contact_id = $_GET['contact_id'];

// On appelle notre classe métier
$sparringManager = new SparringManager();

// Si un message est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $sparringManager->sendMessage($my_id, $contact_id, $_POST['message']);
}

// On récupère l'historique des messages
$messages = $sparringManager->getMessages($my_id, $contact_id);
?>

<div class="box" style="max-width: 600px; margin: auto;">
    <h2 class="title is-5">Chat</h2>
    <div id="chat-window" style="height: 300px; overflow-y: auto; background: #f5f5f5; padding: 10px; border-radius: 5px; margin-bottom: 10px; color: #333;">
        <?php foreach($messages as $m): ?>
            <div style="text-align: <?= $m['id_expediteur'] == $my_id ? 'right' : 'left' ?>; margin-bottom: 5px;">
                <span class="tag <?= $m['id_expediteur'] == $my_id ? 'is-danger' : 'is-dark' ?>">
                    <?= htmlspecialchars($m['contenu']) ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="POST">
        <div class="field has-addons">
            <div class="control is-expanded">
                <input class="input" name="message" type="text" placeholder="Message..." autofocus>
            </div>
            <div class="control">
                <button class="button is-danger">Envoyer</button>
            </div>
        </div>
    </form>
</div>

<script>
    var d = document.getElementById("chat-window"); 
    d.scrollTop = d.scrollHeight;
</script>

<?php include 'includes/footer.php'; ?>