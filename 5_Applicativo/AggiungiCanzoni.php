<!doctype html>
<html lang="it">
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/gestPlaylist.css">
</head>
<body>

<?php 
$metodo = $_SERVER['REQUEST_METHOD']; 
?>

<div class="box center">
    <div class="box-1 center">
        <h2>Aggiungi canzoni</h2>

        <form method="post">
            <div class="center"> 
                Titolo:
                <input type="text" name="titolo" required class="text">
            </div>

            <div class="center"> 
                Artista:
                <input type="text" name="artista" required class="text">
            </div>

            <div class="center"> 
                Album:
                <input type="text" name="album" required class="text">
            </div>

            <input type="submit" name="invia" value="Invia" class="submit center">
        </form>
    </div>
</div>

<?php 
if ($metodo === 'POST') {

    $client_id = "81358678"; 

    // Prendi i dati dal form
    $titolo = $_POST["titolo"];
    $artista = $_POST["artista"];
    $album = $_POST["album"];

    // --- 1. CERCA LA CANZONE SU JAMENDO ---
    $titolo_url = urlencode($titolo);

    $api_url = "https://api.jamendo.com/v3.0/artists/tracks/?client_id=81358678&format=jsonpretty&order=track_name_desc&name=we+are+fm&album_datebetween=0000-00-00_2012-01-01";

    #$api_url = "https://api.jamendo.com/v3.0/artists/tracks/?client_id=$client_id&format=json&limit=1&audioformat=mp31&namesearch=$titolo_url";


    $json = file_get_contents($api_url);

    if ($json === false) {
        die("Errore API Jamendo");
    }

    $data = json_decode($json, true);

    if (!empty($data["results"])) {
        $track = $data["results"][0];
        $url = $track["audio"];
        $cover = $track["album_image"] ?: $track["image"];
    } else {
        $url = "";
        $cover = "";
    }

    // --- 2. INSERIMENTO NEL DATABASE ---
    $conn = new mysqli("localhost","root","","yourmusic");

    if($conn->connect_error){
        die("Connessione fallita: " . $conn->connect_error);
    }

    $query_sql = "INSERT INTO canzone (Titolo, Autore, Album, Url, Cover)
                  VALUES ('$titolo', '$artista', '$album', '$url', '$cover')";

    if($conn->query($query_sql)){
        echo "<script> window.location.href = './home.php'; </script>";
        exit;
    } else {
        echo "Errore inserimento: " . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>
