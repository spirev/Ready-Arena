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

        public function addUser($name, $email, $password, $rank, $ladder_point = 0, $look_for_team = null) {
            $this->db->insert("INSERT INTO users (id, name, email, password, ladder_point, rank, look_for_team)
            VALUES (NULL, '$name', '$email', '$password', '$ladder_point', '$rank', '$look_for_team')");
        }

        public function loginVerify(string $email, string $password) {
            $user = $this->db->getAll("SELECT * FROM users WHERE email = '$email'");
            if(!empty($user)) {
                if(isset($user['password']) && $user['password'] == $password) {
                    return $user;
                }
            }
        }
    }
?>