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

        public function addTournament($name, $game, $maxParticipants, $format, $averageSkill = null, $startDate, $playerList, $round16 = null, $round8 = null, $round4 = null, $round2 = null) {
            $this->db->insert("INSERT INTO tournaments (id, name, game, nbr_participants, format, averageSkill, timer, playerList, round16, round8, round4, round2)
            VALUES (NULL, '$name', '$game', $maxParticipants, '$format', '$averageSkill', '$startDate', '$playerList', '$round16', '$round8', '$round4', '$round2')");
        }
    }
?>