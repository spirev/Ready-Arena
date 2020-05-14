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

        public function maxId() {
            return $this->db->getAll("SELECT MAX(id) FROM tournaments");
        }

        public function addTournament($id, $name, $game, $maxParticipants, $format, $averageSkill = null, $startDate, $playerList, $round16 = null, $round8 = null, $round4 = null, $round2 = null) {
            $this->db->insert("INSERT INTO tournaments (id, name, game, nbr_participants, format, averageSkill, timer, playerList, round16, round8, round4, round2)
            VALUES ($id, '$name', '$game', $maxParticipants, '$format', '$averageSkill', '$startDate', '$playerList', '$round16', '$round8', '$round4', '$round2')");
        }

        public function updatePlayerList($newPlayerList, $id) {
            $this->db->insert("UPDATE tournaments SET playerList = '$newPlayerList' WHERE id = '$id'");
        }

        public function updateRounds($tournamentId, $round, $newRoundList) {
            $this->db->insert("UPDATE tournaments SET $round = '$newRoundList' WHERE id = '$tournamentId'");
        }

        public function TimerOff($tournamentId) {
            $this->db->insert("UPDATE tournaments SET timer = '3000-01-01' WHERE id = $tournamentId");
        }
    }
?>