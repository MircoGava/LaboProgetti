<?php
session_start();
header('Content-Type: application/json');


include 'visualizza.php';
$conn = new mysqli("localhost", "root", "", "yourmusic");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita: " . $conn->connect_error]);
    exit;
}

if (!isset($_SESSION['TitoloPlaylist'])) {
    echo json_encode(["error" => "Playlist non selezionata"]);
    exit;
}

$TitoloPlaylist = $conn->real_escape_string($_SESSION['TitoloPlaylist']);

$query = "SELECT c.Autore, c.Titolo
FROM canzone AS c
JOIN contiene AS co 
ON co.fk_titoloCanzoni = c.Titolo
WHERE co.fk_titoloPlaylist = '$TitoloPlaylist'";

$result = $conn->query($query);

$songs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

$conn->close();


echo json_encode($songs);
