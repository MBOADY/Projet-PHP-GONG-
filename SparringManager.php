<?php
require_once 'Database.php';

class SparringManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Gérer l'envoi de message
    public function sendMessage($expediteur, $destinataire, $contenu) {
        $stmt = $this->db->prepare("INSERT INTO message (id_expediteur, id_destinataire, contenu) VALUES (?, ?, ?)");
        return $stmt->execute([$expediteur, $destinataire, $contenu]);
    }

    // Récupérer la discussion entre deux membres
    public function getMessages($user1, $user2) {
        $stmt = $this->db->prepare("SELECT * FROM message WHERE (id_expediteur = ? AND id_destinataire = ?) OR (id_expediteur = ? AND id_destinataire = ?) ORDER BY date_envoi ASC");
        $stmt->execute([$user1, $user2, $user2, $user1]);
        return $stmt->fetchAll();
    }

  // Enregistrer une demande (Max 2 demandes à la même personne)
    public function proposeSparring($id_demandeur, $id_partenaire) {
        // 1. Règle métier : Compter combien de demandes ont déjà été envoyées à ce partenaire précis
        $stmtCount = $this->db->prepare("SELECT COUNT(*) FROM session_sparring WHERE id_demandeur = ? AND id_partenaire = ?");
        $stmtCount->execute([$id_demandeur, $id_partenaire]);
        $count = $stmtCount->fetchColumn();

        if ($count >= 2) {
            return 'limite_atteinte'; // On bloque pour éviter le spam
        }

        // 2. Vérifier s'il n'y a pas DÉJÀ une demande "En attente" pour cette personne
        $check = $this->db->prepare("SELECT id_session FROM session_sparring WHERE id_demandeur = ? AND id_partenaire = ? AND statut = 'En attente'");
        $check->execute([$id_demandeur, $id_partenaire]);
        
        if (!$check->fetch()) {
            // 3. Si tout est bon, on insère
            $stmt = $this->db->prepare("INSERT INTO session_sparring (id_demandeur, id_partenaire, statut) VALUES (?, ?, 'En attente')");
            $stmt->execute([$id_demandeur, $id_partenaire]);
            return 'succes';
        }
        return 'doublon';
    }

    // Mettre à jour le statut (Accepter/Refuser)
    public function updateSparringStatus($id_session, $id_partenaire, $statut) {
        $stmt = $this->db->prepare("UPDATE session_sparring SET statut = ? WHERE id_session = ? AND id_partenaire = ?");
        return $stmt->execute([$statut, $id_session, $id_partenaire]);
    }

    // Récupérer les demandes reçues
    public function getReceivedRequests($user_id) {
        $stmt = $this->db->prepare("SELECT s.*, u.prenom, u.nom, u.sport_principal FROM session_sparring s JOIN utilisateur u ON s.id_demandeur = u.id_utilisateur WHERE s.id_partenaire = ? ORDER BY s.date_creation DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    // Récupérer les demandes envoyées
    public function getSentRequests($user_id) {
        $stmt = $this->db->prepare("SELECT s.*, u.prenom, u.nom FROM session_sparring s JOIN utilisateur u ON s.id_partenaire = u.id_utilisateur WHERE s.id_demandeur = ? ORDER BY s.date_creation DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}