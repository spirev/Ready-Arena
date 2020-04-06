<?php
    class UsersModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function findAllByPoints() {
            return $this->db->getAll("SELECT * FROM users ORDER BY ladder_point DESC");
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