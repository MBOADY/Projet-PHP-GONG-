<?php
require_once 'Database.php';

class ClubManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllClubs() {
        $stmt = $this->db->query("SELECT * FROM club");
        return $stmt->fetchAll();
    }

    // Ajouter un nouveau club
    public function addClub($nom, $latitude, $longitude, $sports) {
        $stmt = $this->db->prepare("INSERT INTO club (nom, latitude, longitude, sports_proposes) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $latitude, $longitude, $sports]);
    }
}