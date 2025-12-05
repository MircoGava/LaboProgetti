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
            <p>Titolo:</p>
            <input type="text" name="titolo" required class="text" placeholder="Titolo della canzone">

            <p>Artista:</p>
            <input type="text" name="artista" required class="text" placeholder="Autore della canzone">

            <p>Album:</p>
            <input type="text" name="album" required class="text" placeholder="Album">

            <div class="center">
                <input type="submit" name="invia" value="Invia" class="submit center">
            </div>
        </form>
        <p onclick="Annulla();"><b><u>Annulla</u></b></p>
    </div>
</div>

<?php 
//Controlla che il metodo utilizzato sia post in modo che non esce codice inutile
if ($metodo === 'POST' && isset($_POST['invia'])) {

    //id per jamando messo in variabile in modo che è èiù chiaro
    $client_id = "81358678"; 

    //Prende i dati dal post
    $titolo = trim($_POST["titolo"]);
    $artista = trim($_POST["artista"]);
    $album = trim($_POST["album"]);

    //Trasforma il titolo e l'artista della canzone in un url che servirà poi per la api per trovare i dati
    $search_query = urlencode("$titolo $artista");
    //Collegamento alla api, usando l'id va a cercare i dati della traccia da noi selezionata, va  aprendere i dati in formato json e prende la traccia audio in formato mp3
    $api_url = "https://api.jamendo.com/v3.0/tracks/?client_id=$client_id&format=json&limit=10&audioformat=mp32&search=$search_query";

    //Comandi che servono a far partire api e a farla funzionare (aiuto della ai)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'YourMusicApp/1.0');
    
    $json = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $url = "";
    $cover = "";
    //Se non riesce a collegarsi alla api da questo errore
    if ($json === false || $http_code !== 200) {
        echo "<div>Errore nella connessione all'API Jamendo (HTTP: $http_code)</div>";
    } else {
        //Se si è riuscito a collegare allora prende i dati che gli sono stati restituiti (che erano in fomrato json) e gli legge
        $data = json_decode($json, true);
        
        //se i dati non sono vuoti allora da riempe url e la cover un percorso che permette al file js di usare per far funzionare l'applicativo
        if (!empty($data["results"]) && isset($data["results"][0])) {
            $track = $data["results"][0];
            
           
            if (isset($track["audio"])) {
                $url = $track["audio"];
            }
            if (isset($track["album_image"])) {
                $cover = $track["album_image"];
            }
            
        } else {
            echo "<div>Nessuna traccia trovata su Jamendo per: $titolo - $artista</div>";
        }
    }

    //Connessione al database
    try {
        $conn = new mysqli("localhost", "root", "", "yourmusic");
        
        if($conn->connect_error){
            throw new Exception("Connessione fallita: " . $conn->connect_error);
        }

       //Si assiccura che tutti i dati che sono stati ricevuti siano delle stringhe
        $titolo = $conn->real_escape_string($titolo);
        $artista = $conn->real_escape_string($artista);
        $album = $conn->real_escape_string($album);
        $url = $conn->real_escape_string($url);
        $cover = $conn->real_escape_string($cover);

        //Inserisce i dati nel database --> precisamente il database yourmusic nella tabella canzoni
        $query_sql = "INSERT INTO canzone (Titolo, Autore, Album, Url, Cover)
                      VALUES ('$titolo', '$artista', '$album', '$url', '$cover')";

        if($conn->query($query_sql)){
            echo "<div>Canzone inserita con successo!</div>";
            //Ci riporta nella pagina dove possiamo aggiungere canzoni alla playlist
            //C'è un setTime perchè quando non funzionava mi permetteva di leggere gli errori che mi dava --> ora è baso perchè funziona 
            echo "<script> setTimeout(function() { window.location.href = 'aggCanzPlay.html'; }, 100); </script>";
        } else {
            throw new Exception("Errore inserimento: " . $conn->error);
        }

        $conn->close();
        
    } catch (Exception $e) {
        echo "<div>Errore database: " . $e->getMessage() . "</div>";
        
    }
}
?>
<script>
 function Annulla() {
            window.location.href = 'AggCanzPlay.html';
        }
</script>

</body>
</html>