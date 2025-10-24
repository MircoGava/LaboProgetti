<?php

$conn = new mysqli("localhost", "root", "", "yourmusic");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connessione fallita: " . $conn->connect_error]));
}

$query_titoli = "SELECT Titolo FROM canzone";
$query_autori = "SELECT Autore FROM canzone";

$result_titoli = $conn->query($query_titoli);
$titoli = [];
if ($result_titoli && $result_titoli->num_rows > 0) {
    while ($row = $result_titoli->fetch_assoc()) {
        $titoli[] = $row['Titolo'];
    }
}

$result_autori = $conn->query($query_autori);
$autori = [];
if ($result_autori && $result_autori->num_rows > 0) {
    while ($row = $result_autori->fetch_assoc()) {
        $autori[] = $row['Autore'];
    }
}

$conn->close();

function storeData($titoli, $autori){
    $new_song = [
        "Titolo" => $titoli,
        "Autore" => $autori,
    ];
}

foreach ($new_song as $value){
    if($value == ""){
        return "All field are required";
    }
}

$messaggio = array_map(function($item){
    return htmlspecialchars($item);
}, $new_song);


if(filesize("dati.json") == 0)
{
    $data_to_save = array($messaggio);
}else{
    $old_records = json_decode(file_get_contents("dati.json"), true);
    array_push($old_records, $messaggio);
    $data_to_save = $old_records;
}


?>
