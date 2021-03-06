<?php

    class TournamentsModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function findAll() {
            return $this->db->getAll("SELECT * FROM tournaments ORDER BY id ASC");
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

        public function findByFormat($format) {
            return $this->db->getAll("SELECT * FROM tournaments WHERE format = '$format'");
        }

        public function addTournament($id, $name, $game, $maxParticipants, $format, $averageSkill = null, $startDate, $playerList, $round16 = null, $round8 = null, $round4 = null, $round2 = null, $played = 0) {
            $this->db->insert("INSERT INTO tournaments (id, name, game, nbr_participants, format, averageSkill, timer, playerList, round16, round8, round4, round2, played)
            VALUES ('$id', '$name', '$game', '$maxParticipants', '$format', '$averageSkill', '$startDate', '$playerList', '$round16', '$round8', '$round4', '$round2', '$played')");
        }

        public function updateId($oldId, $newID) {
            $this->db->insert("UPDATE tournaments SET id = $newID WHERE id = $oldId");
        }

        public function updatePlayerList($newPlayerList, $id) {
            $this->db->insert("UPDATE tournaments SET playerList = '$newPlayerList' WHERE id = '$id'");
        }

        public function updateRounds($tournamentId, $round, $newRoundList) {
            $this->db->insert("UPDATE tournaments SET $round = '$newRoundList' WHERE id = '$tournamentId'");
        }

        public function updateTimer($tournamentId, $date) {
            $this->db->insert("UPDATE tournaments SET timer = '$date' WHERE id = $tournamentId");
        }

        public function setAsPlayed($tournamentId) {
            $this->db->insert("UPDATE tournaments SET played = 1 WHERE id = $tournamentId");
        }

        public function deleteTournament($tournamentId) {
            $this->db->insert("DELETE FROM tournaments WHERE id = $tournamentId");
        }
    }
?>