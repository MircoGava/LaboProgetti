<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
    
    //Prende la variabile username detta in precedenza
    session_start();

        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        $username = $_SESSION['username'];
        //connessione a database
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        //Legge i dati che l'utente ha inserito nel html e gli trasforma in delle variabili
        $titolo = $_POST["Titolo"];
        $bio = $_POST["Bio"];

        //inserisce nella tabella playlist i dati che l'utente ha inserito in precedenza
        $query_sql = "INSERT INTO  
                    playlist (Titolo,Bio, fk_username) 
                    VALUES ('$titolo', '$bio','$username');";

        $risultato = $conn->query($query_sql);

        //Se va a buon fine riporta l'user nella home, altrimenti gli da un errore
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