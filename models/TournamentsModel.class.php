<?php

    class TournamentsModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function findAll() {
            return $this->db->getAll("SELECT * FROM tournaments");
        }

        public function findByGame($game) {
            return $this->db->getAll("SELECT * FROM tournaments WHERE game = '$game'");
        }

        public function findById($id) {
            return $this->db->getAll("SELECT * FROM tournaments WHERE id = '$id'");
        }
    }
?>