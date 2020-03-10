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
    }
?>