<?php

    class TeamsModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function findAll() {
            return $this->db->getAll("SELECT * FROM teams");
        }

        public function findLFP($game) {
            return $this->db->getAll("SELECT * FROM teams WHERE look_for_player = 1 AND game = '$game'");
        }

        public function findById($id) {
            return $this->db->getAll("SELECT *FROM teams WHERE id = '$id'");
        }
    }

?>