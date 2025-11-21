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

// Connessione al database
$conn = new mysqli("localhost", "root", "", "yourmusic");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita: " . $conn->connect_error]);
    exit;
}

// Query per prendere le canzoni della playlist
$query = "
    SELECT c.Autore, c.Titolo
    FROM canzone AS c
    JOIN contiene AS co 
        ON co.fk_titoloCanzoni = c.Titolo
    WHERE co.fk_titoloPlaylist = '$TitoloPlaylist'
";

$result = $conn->query($query);

// Array finale da restituire al JS
$songs = [];

if ($result && $result->num_rows > 0) {

    // Codice che prende i dati dalla api (chat gpt)
    while ($row = $result->fetch_assoc()) {

        $titolo  = urlencode($row["Titolo"]);
        $autore  = urlencode($row["Autore"]);

        // API di ricerca brano su Jamendo
        $jamendo_url = 
            "https://api.jamendo.com/v3.0/tracks/?" .
            "client_id=$client_id" .
            "&format=json" .
            "&limit=1" .
            "&namesearch=$titolo";

        $apiResponse = file_get_contents($jamendo_url);
        $apiData = json_decode($apiResponse, true);

        // Se Jamendo ha trovato un brano
        if (isset($apiData["results"][0])) {

            $track = $apiData["results"][0];

            $songs[] = [
                "Autore" => $track["artist_name"],
                "Titolo" => $track["name"],
                "Url"    => $track["audio"],
                "Cover" => $track["image"]     
            ];
        } else {

            // Se Jamendo NON trova la canzone
            $songs[] = [
                "Autore" => $row["Autore"],
                "Titolo" => $row["Titolo"],
                "Url"    => null
            ];
        }
    }
}

$conn->close();

// RESTITUISCE I DATI ALLO SCRIPT JS
echo json_encode($songs);
?>
