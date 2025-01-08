<?php
class GameService
{
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=mysql-db;dbname=chess_db';
        $username = 'username';
        $password = 'password';
        $this->pdo = new PDO($dsn, $username, $password);
    }

    public function getGames()
    {
        $stmt = $this->pdo->query('SELECT * FROM games');
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Fetch as objects
    }

    public function getPlayerGames($player)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM games WHERE black = :player OR white = :player');
        $stmt->execute([':player' => $player]);
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Fetch as objects
    }

    public function addGame($black, $white, $winner, $moves)
    {
        $stmt = $this->pdo->prepare("INSERT INTO games (black, white, winner, moves, created_at) VALUES (:black, :white, :winner, :moves, :created_at)");
        $stmt->execute([
            ':black' => $black,
            ':white' => $white,
            ':winner' => $winner,
            ':moves' => $moves,
            ':created_at' => date('Y-m-d H:i:s') // Set the current timestamp
        ]);
    }
}

// Create a new SOAP server
$server = new SoapServer(null, [
    'uri' => 'http://localhost/soap-server.php'
]);

// Set the class handling the SOAP requests
$server->setClass('GameService');

// Handle the SOAP requests
$server->handle();