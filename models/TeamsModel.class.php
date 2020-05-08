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

        public function addTeam($name, $game, $captain, $LFP, $comment, $teammates) {
            $this->db->insert("INSERT INTO teams (id, name, game, family, captain, look_for_player, comment, teammates)
                                VALUES (NULL, '$name', '$game', NULL, '$captain', '$LFP', '$comment', '$teammates')");
        }

        public function addTeammates($teamId, $newTeammates) {
            $this->db->insert("UPDATE teams SET teammates = '$newTeammates' WHERE id = '$teamId'");
        }

        public function updateWaitingPlayer($teamId, $newWaitingList) {
            $this->db->insert("UPDATE teams SET waiting_list = '$newWaitingList' WHERE id = '$teamId'");
        }

        public function updateComment($teamId, $newComment) {
            $this->db->insert("UPDATE teams SET comment = '$newComment' WHERE id = '$teamId'");
        }
    }

?>