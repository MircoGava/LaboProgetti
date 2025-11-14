<?php
session_start();
header('Content-Type: application/json');



// Si collega al database
$conn = new mysqli("localhost", "root", "", "yourmusic");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita: " . $conn->connect_error]);
    exit;
}
//Prende dal file il nome della playlist su cui bisogna lavorare
if (!isset($_SESSION['TitoloPlaylist'])) {
    echo json_encode(["error" => "Playlist non selezionata"]);
    exit;
}

//Reiepe la variabile con il nome della playlist su cui ci si trova
$TitoloPlaylist = $conn->real_escape_string($_SESSION['TitoloPlaylist']);

//Query per selezionare solo le canzoni che sono all'interno di quella playlist
$query = "SELECT c.Autore, c.Titolo
FROM canzone AS c
JOIN contiene AS co 
ON co.fk_titoloCanzoni = c.Titolo
WHERE co.fk_titoloPlaylist = '$TitoloPlaylist'";

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


echo json_encode($songs);
