<?php

class Database{

    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO
        (
            "mysql:host=localhost;dbname=readyarena;charset=utf8",
            "root",
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public function getAll(string $sql) {
        $query = $this->pdo->query($sql);
        return $query->fetchAll();
    }

    public function insert(string $sql) {
        $query = $this->pdo->query($sql);
    }
}

?>