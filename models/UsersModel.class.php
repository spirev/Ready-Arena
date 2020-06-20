<?php
    class UsersModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        
        public function findAll() {
            return $this->db->getAll("SELECT * FROM users");
        }
        
        public function findById(int $id) {
            return $this->db->getAll("SELECT * FROM users WHERE id = '$id'");
        }
        
        public function findByEmail(string $email) {
            return $this->db->getAll("SELECT * FROM users WHERE email = '$email'");
        }
        
        public function findByName() {
            return $this->db->getAll("SELECT * FROM users ORDER BY name ASC");
        }
        
        public function checkName($name) {
            return $this->db->getAll("SELECT * FROM users WHERE name = '$name'");
        }
        
        public function findAllByPoints() {
            return $this->db->getAll("SELECT * FROM users ORDER BY ladder_point DESC");
        }

        public function lowerestPoint() {
            return $this->db->getAll("SELECT * FROM users WHERE ladder_point = 0");
        }

        public function updateLadderPoints($userID, $ladderPointsWin) {
            $this->db->insert("UPDATE users SET ladder_point = $ladderPointsWin WHERE id = $userID");
        }

        public function findLowerstRanks() {
            return $this->db->getAll("SELECT MAX(rank) FROM users");
        }

        public function updateRank($userId, $newRank) {
            $this->db->insert("UPDATE users SET rank = '$newRank' WHERE id = $userId");
        }

        public function maxId() {
            return $this->db->getAll("SELECT MAX(id) FROM users");
        }

        public function updateLFT($userId, $newLFT) {
            $this->db->insert("UPDATE users SET look_for_team = '$newLFT' WHERE id = '$userId'");
        }

        public function updateTeamInvite($newTeamInvite, $id) {
            $this->db->insert("UPDATE users SET team_invite = '$newTeamInvite' WHERE id = '$id'");
        }

        public function updateComment($userId, $newComment) {
            $this->db->insert("UPDATE users SET comment = '$newComment' WHERE id = '$userId'");
        }

        public function addUser($id, $name, $email, $password, $rank, $ladder_point = 0, $look_for_team = null) {
            $this->db->insert("INSERT INTO users (id, name, email, password, ladder_point, rank, look_for_team)
            VALUES ($id, '$name', '$email', '$password', '$ladder_point', '$rank', '$look_for_team')");
        }

        public function loginVerify(string $email, string $password) {
            $user = $this->db->getAll("SELECT * FROM users WHERE email = '$email'");
            if(!empty($user)) {
                if(password_verify($password, $user[0]['password'])) {
                    return $user;
                }
            }
        }
    }
?>