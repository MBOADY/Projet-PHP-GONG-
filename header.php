<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- VÉRIFICATION DU RÔLE ADMIN ---
$isAdmin = false;
if (isset($_SESSION['user_id'])) {
    require_once 'classes/UserManager.php';
    $userMgr = new UserManager();
    $userData = $userMgr->getUserById($_SESSION['user_id']);
    // On vérifie si la colonne role existe et si elle vaut "admin"
    if ($userData && isset($userData['role']) && $userData['role'] === 'admin') {
        $isAdmin = true;
    }
}
// ----------------------------------
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GONG - Sparring & Training</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .navbar { border-bottom: 1px solid #333; }
        .logo-gong { font-weight: 900; letter-spacing: -1px; color: #ff3860 !important; }
        #chat-window::-webkit-scrollbar { width: 5px; }
        #chat-window::-webkit-scrollbar-thumb { background: #ff3860; border-radius: 10px; }
    </style>
</head>
<body>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item logo-gong is-size-3" href="index.php">
        <i class="fa-solid fa-gong mr-2"></i>GONG
      </a>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMain">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarMain" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="index.php">
          <i class="fas fa-home mr-2"></i> Accueil
        </a>
        <a class="navbar-item" href="clubs.php">
          <i class="fas fa-map-marker-alt mr-2"></i> Carte des Clubs
        </a>
        <a class="navbar-item" href="ia.php">
          <i class="fas fa-robot mr-2"></i> Coach IA
        </a>
        <a class="navbar-item" href="tutos.php">
          <i class="fas fa-graduation-cap mr-2"></i> Tutos & FAQ
        </a>
        <a class="navbar-item" href="notre_club.php"><i class="fas fa-shield-halved mr-2"></i> Notre Club</a>
      </div>

      <div class="navbar-end">
        <?php if(isset($_SESSION['user_id'])): ?>
            
            <?php if($isAdmin): ?>
                <a class="navbar-item has-text-danger" href="admin.php">
                    <strong><i class="fas fa-crown mr-2"></i> Panel Admin</strong>
                </a>
            <?php endif; ?>
            <a class="navbar-item" href="notifications.php">
              <span class="icon-text">
                <span class="icon has-text-danger"><i class="fas fa-bell"></i></span>
                <span>Notifications</span>
              </span>
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link">
                <i class="fas fa-user-circle mr-2"></i> <?= htmlspecialchars($_SESSION['prenom']) ?>
              </a>
              <div class="navbar-dropdown is-right">
                <a class="navbar-item" href="profil.php">Mon Profil</a>
                <hr class="navbar-divider">
                <a class="navbar-item has-text-danger" href="logout.php">Déconnexion</a>
              </div>
            </div>
        <?php else: ?>
            <div class="navbar-item">
              <div class="buttons">
                <a href="register.php" class="button is-danger"><strong>Inscription</strong></a>
                <a href="login.php" class="button is-light is-outlined">Connexion</a>
              </div>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<section class="section">
  <div class="container">
