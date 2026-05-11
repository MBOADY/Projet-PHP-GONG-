<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/SparringManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $sparringManager = new SparringManager();
    
    // On récupère le résultat de la tentative de demande
    $result = $sparringManager->proposeSparring($_SESSION['user_id'], $_POST['id_partenaire']);
    
    // On redirige avec le bon message
    if ($result === 'limite_atteinte') {
        header("Location: index.php?error=limite");
    } else {
        header("Location: index.php?success=1");
    }
    exit();
} else {
    header("Location: index.php");
    exit();
}