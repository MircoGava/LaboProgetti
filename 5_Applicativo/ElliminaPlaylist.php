<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
        //prende la variabile username e la rende utilizzabile per questa pagina
        session_start();

        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        $username = $_SESSION['username'];
    //Connessione a database
        $conn = new mysqli("localhost","root","","yourmusic" );
        //Verifica che la connessione sia andata a buon fine e in caso contrario di da un codice di errore
        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }
        //Trasforma il nome inserito dall'utente in una variabile
        $titolo = $_POST["Titolo"];
        //usa la variabile per elliminare la playlist richiesta dall'utente dal database, fa anche in modo che l'user non possa elliminare playlist di altri utenti
        $query_sql = "DELETE FROM playlist 
                    WHERE Titolo = '$titolo'
                    AND fk_username = '$username' ";

        $risultato = $conn->query($query_sql);
        //Se l'elliminazione è andata a buon fine ti riporta alla home altrimenti ti da errore
        if($risultato == TRUE){
            echo "<script> function home() {
                window.location.href = './home.php';
             } 
             home(); </script>";
        } else {
            echo "Inserimento non avvenuto con successo; $query_sql";
        }

    
    ?>

</body>
</html>