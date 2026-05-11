<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'classes/UserManager.php';

// Si l'utilisateur est déjà connecté, on le renvoie à l'accueil
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    // On sécurise le mot de passe avant de l'envoyer à la classe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ville = trim($_POST['ville']);
    $poids = $_POST['poids'];
    $taille = $_POST['taille']; 
    $sport = $_POST['sport'];

    // Instanciation de l'objet
    $userManager = new UserManager();
    
    // Appel de la méthode d'inscription
    if ($userManager->register($nom, $prenom, $email, $password, $ville, $poids, $taille, $sport)) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $erreur = "Erreur lors de l'inscription. Cet email est peut-être déjà utilisé.";
    }
}

include 'includes/header.php';
?>

<div class="columns is-centered">
    <div class="column is-4">
        <form method="POST" action="register.php" class="box mt-5" style="border-top: 4px solid #ff3860;">
            <div class="has-text-centered mb-4">
                <span class="icon has-text-danger is-large"><i class="fas fa-user-plus fa-2x"></i></span>
                <h1 class="title is-4 mt-2">Rejoindre GONG</h1>
            </div>
            
            <?php if($erreur): ?>
                <div class="notification is-danger is-light"><?= $erreur ?></div>
            <?php endif; ?>
            
            <div class="field">
                <input class="input" type="text" name="nom" placeholder="Nom" required>
            </div>
            <div class="field">
                <input class="input" type="text" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="field">
                <input class="input" type="email" name="email" placeholder="Email" required>
            </div>
            <div class="field">
                <input class="input" type="password" name="password" placeholder="Mot de passe" required>
            </div>
            <div class="field">
                <input class="input" type="text" name="ville" placeholder="Ville (ex: Niort)" required>
            </div>
            
            <div class="columns is-mobile">
                <div class="column">
                    <div class="field">
                        <label class="label is-small">Poids (kg)</label>
                        <input class="input" type="number" name="poids" placeholder="70" required>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label is-small">Taille (cm)</label>
                        <input class="input" type="number" name="taille" placeholder="175" required>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <label class="label is-small">Sport de combat</label>
                <input class="input" name="sport" list="sports-list" placeholder="Tapez pour chercher..." required>
                <datalist id="sports-list">
                    <option value="MMA"><option value="Boxe Anglaise"><option value="Muay Thaï"><option value="Kickboxing">
                    <option value="Jiu-Jitsu Brésilien"><option value="Lutte"><option value="Judo"><option value="Karaté">
                    <option value="Savate"><option value="Sambo"><option value="Grappling"><option value="Krav Maga">
                    <option value="Taekwondo"><option value="Luta Livre"><option value="Aïkido"><option value="Kendo"><option value="Sanda">
                </datalist>
            </div>
            
            <button type="submit" class="button is-danger is-fullwidth mt-4">Créer mon compte</button>
            
            <div class="has-text-centered mt-4">
                <a href="login.php" class="has-text-grey">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>