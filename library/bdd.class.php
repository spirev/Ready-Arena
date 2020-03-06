<?php
    /* try to connect to DB */

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
        /*$query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);*/
        $query = $this->pdo->query($sql);
        return $query->fetchAll();
    }
}
/*try{
    $user = 'root';
    $password = '';
    $dbname = 'readyarena';
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ); 
}catch(PDOException $e){
    echo "Hello , votre prof qui vous manque vous dit qu'il y a eu un sushi : ". $e->getMessage()."<br> Statut code : ".$e->getCode();
}*/
?>