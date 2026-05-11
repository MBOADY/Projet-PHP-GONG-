<?php
require_once 'Database.php';

class UserManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // 1. Connexion
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }

    // 2. Inscription
    public function register($nom, $prenom, $email, $password, $ville, $poids, $taille, $sport) {
        try {
            $stmt = $this->db->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, ville, poids, taille, sport_principal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nom, $prenom, $email, $password, $ville, $poids, $taille, $sport]);
        } catch (PDOException $e) {
            return false; 
        }
    }

    // 3. Récupérer un utilisateur
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // 4. Modifier le profil
    public function updateProfile($id, $prenom, $nom, $ville, $poids, $taille, $sport, $niveau, $experience) {
        $stmt = $this->db->prepare("UPDATE utilisateur SET prenom = ?, nom = ?, ville = ?, poids = ?, taille = ?, sport_principal = ?, niveau = ?, experience_annees = ? WHERE id_utilisateur = ?");
        return $stmt->execute([$prenom, $nom, $ville, $poids, $taille, $sport, $niveau, $experience, $id]);
    }

    // 5. Rechercher des partenaires (avec filtres optionnels)
    public function searchUsers($currentUserId, $ville = '', $sport = '') {
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur != ?";
        $params = [$currentUserId];

        if (!empty($ville)) {
            $sql .= " AND ville LIKE ?";
            $params[] = '%' . $ville . '%';
        }
        if (!empty($sport)) {
            $sql .= " AND sport_principal LIKE ?";
            $params[] = '%' . $sport . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // 6. Calcul de l'IMC
    public function calculateIMC($poids, $taille) {
        if ($poids > 0 && $taille > 0) {
            $tailleMetres = $taille / 100;
            return round($poids / ($tailleMetres * $tailleMetres), 1);
        }
        return 0;
    }

    // Vérifier l'ancien mot de passe et mettre à jour
    public function changePassword($id_utilisateur, $nouveau_mdp) {
        $nouveau_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id_utilisateur = ?");
        return $stmt->execute([$nouveau_hash, $id_utilisateur]);
    }

    // Récupérer les 6 profils les plus pertinents (Matchmaking amélioré)
    public function getBestMatches($currentUserId, $userSport, $userVille, $userPoids) {
        // Logique de score : 
        // +2 points si même sport
        // +1 point si même ville
        // +1 point si le poids est à +/- 5kg (catégorie de poids proche)
        $sql = "SELECT *, 
                (CASE WHEN sport_principal = ? THEN 2 ELSE 0 END) + 
                (CASE WHEN ville = ? THEN 1 ELSE 0 END) +
                (CASE WHEN poids BETWEEN (? - 5) AND (? + 5) THEN 1 ELSE 0 END) AS match_score 
                FROM utilisateur 
                WHERE id_utilisateur != ? 
                ORDER BY match_score DESC, date_inscription DESC 
                LIMIT 6";
        $stmt = $this->db->prepare($sql);
        // On passe les paramètres dans l'ordre des "?"
        $stmt->execute([$userSport, $userVille, $userPoids, $userPoids, $currentUserId]);
        return $stmt->fetchAll();
    }

    // 9. Récupérer tous les utilisateurs (Pour l'Admin)
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id_utilisateur, nom, prenom, email, ville, sport_principal, role, date_inscription FROM utilisateur ORDER BY date_inscription DESC");
        return $stmt->fetchAll();
    }

    // 10. Supprimer un utilisateur (Bannissement)
    public function deleteUser($id_utilisateur) {
        // En base de données, il faut aussi penser aux clés étrangères
        // (La suppression en cascade dans phpMyAdmin est recommandée, sinon on supprime manuellement ici)
        $stmtSession = $this->db->prepare("DELETE FROM session_sparring WHERE id_demandeur = ? OR id_partenaire = ?");
        $stmtSession->execute([$id_utilisateur, $id_utilisateur]);

        $stmtMsg = $this->db->prepare("DELETE FROM message WHERE id_expediteur = ? OR id_destinataire = ?");
        $stmtMsg->execute([$id_utilisateur, $id_utilisateur]);

        $stmt = $this->db->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
        return $stmt->execute([$id_utilisateur]);
    }
}