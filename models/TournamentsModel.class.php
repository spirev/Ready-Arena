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

        public function findByName($game) {
            return $this->db->getAll("SELECT * FROM tournaments WHERE game = '$game'");
        }
    }
?>