<?php
    class GamesModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function findAll() {
            return $this->db->getAll("SELECT * FROM games");
        }

        public function findByName($name) {
            return $this->db->getAll("SELECT * FROM games WHERE name = '$name'");
        }
    }
?>