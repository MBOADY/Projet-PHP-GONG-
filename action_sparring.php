<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'classes/SparringManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $sparringManager = new SparringManager();
    $sparringManager->updateSparringStatus($_POST['id_session'], $_SESSION['user_id'], $_POST['action']);
    header("Location: notifications.php");
    exit();
}