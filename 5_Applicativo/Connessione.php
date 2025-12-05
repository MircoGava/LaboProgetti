<?php
session_start();
header('Content-Type: application/json');

// Connessione ad aip --> id del profilo 
$client_id = "81358678";

// Controlla che la playlist sia selezionata
if (!isset($_SESSION['TitoloPlaylist'])) {
    echo json_encode(["error" => "Playlist non selezionata"]);
    exit;
}

// Nome playlist
$TitoloPlaylist = $_SESSION['TitoloPlaylist'];

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Username non trovato"]);
    exit;
}
$username = $_SESSION['username'];

if (!isset($_SESSION['Titolo'])) {
    echo json_encode(["error" => "Username non trovato"]);
    exit;
}
$titoloCanzone = $_SESSION['Titolo'];

if($titoloCanzone == null)
{
    $scelta = null;
}else {
    $scelta = $titoloCanzone;
}

// Connessione al database
$conn = new mysqli("localhost", "root", "", "yourmusic");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita: " . $conn->connect_error]);
    exit;
}

// Query per prendere le canzoni della playlist
$query = "
    SELECT c.id, c.Autore, c.Titolo, c.Url, c.Cover
    FROM canzone AS c
    JOIN contiene AS co 
    ON co.fk_idCanzone = c.id
    WHERE co.fk_titoloPlaylist = '$TitoloPlaylist'
    AND co.fk_username = '$username'
";

$result = $conn->query($query);

//Riempe la variabile con il titolo e l'autore di quelle canzoni in modo che il file js le possa usare
$songs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

//chiude la connessione al database
$conn->close();


echo json_encode([
    'song' => $songs,
    'scelta' => $scelta
]);
