<?php
// On démarre la session en premier
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On appelle notre nouvelle classe
require_once 'classes/UserManager.php';

// Si l'utilisateur est déjà connecté, on le renvoie vers l'accueil
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$erreur = null;

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. On crée notre objet UserManager
    $userManager = new UserManager();

    // 2. On utilise sa méthode "login"
    $user = $userManager->login($email, $password);

    if ($user) {
        // Connexion réussie : on stocke en session
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['nom'] = $user['nom'];
        
        header("Location: profil.php");
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}

// On inclut le header APRES la logique PHP
include 'includes/header.php';
?>

<div class="columns is-centered">
    <div class="column is-4">
        <form method="POST" action="login.php" class="box mt-6" style="border-top: 4px solid #ff3860;">
            <div class="has-text-centered mb-5">
                <span class="icon has-text-danger is-large"><i class="fas fa-right-to-bracket fa-2x"></i></span>
                <h2 class="title is-4 mt-2">Connexion à GONG</h2>
            </div>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="notification is-success is-light">Inscription réussie ! Vous pouvez vous connecter.</div>
            <?php endif; ?>

            <?php if($erreur): ?>
                <div class="notification is-danger is-light"><?= $erreur ?></div>
            <?php endif; ?>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="cedric@gong.fr" required>
                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                </div>
            </div>

            <div class="field">
                <label class="label">Mot de passe</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" name="password" placeholder="********" required>
                    <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                </div>
            </div>

            <div class="field mt-5">
                <div class="control">
                    <button type="submit" class="button is-danger is-fullwidth">Se connecter</button>
                </div>
            </div>
            
            <div class="has-text-centered mt-4">
                <a href="register.php" class="has-text-grey">Pas encore de compte ? S'inscrire</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>