<?php
class Database {
    private static $instance = null;
    private $pdo;

    // Le constructeur est privé : on ne peut pas faire "new Database()" de l'extérieur
    private function __construct() {
        $host = 'localhost';
        $dbname = 'gong';
        $user = 'root';
        $pass = ''; // Mets ton mot de passe si tu en as un sur Laragon/WAMP

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            // On active les erreurs PDO
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // On renvoie les données sous forme de tableau associatif par défaut
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // La méthode magique pour récupérer la connexion PDO
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}