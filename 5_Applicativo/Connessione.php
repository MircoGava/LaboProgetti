<?php
header('Content-Type: application/json');

// Connessione al database
$conn = new mysqli("localhost", "root", "", "yourmusic");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita: " . $conn->connect_error]);
    exit;
}

// Query unica per prendere autore e titolo insieme
$query = "SELECT Autore, Titolo FROM canzone";
$result = $conn->query($query);

$songs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

$conn->close();

// Restituisce un array JSON di oggetti
echo json_encode($songs);
