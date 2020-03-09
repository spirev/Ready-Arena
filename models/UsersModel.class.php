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
    }
?>