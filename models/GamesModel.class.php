<?php
    /*include 'library/bdd.class.php';*/
    class GamesModel {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function findAll() {
            $sql = "SELECT * FROM games";
            return $this->db->getAll($sql);
        }
    }
?>