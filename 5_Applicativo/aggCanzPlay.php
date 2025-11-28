<?php
//Codice che serve a recuperare il nome della playlist in cui si sta lavorando tramite una variabile esterna
session_start();

    if (!isset($_SESSION['TitoloPlaylist'])) {
        echo json_encode(["error" => "Playlist non selezionata"]);
        exit;
    }

    // Nome playlist
    $TitoloPlaylist = $_SESSION['TitoloPlaylist'];
    //connessione a database
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        //Legge i dati che l'utente ha inserito nel html e gli trasforma in delle variabili
        $titolo = $_POST["Titolo"];
        $artista = $_POST["Artista"];

        //Controlla se la canzone esiste veramente
        $controllo = "SELECT id
                      FROM canzone
                      where Titolo = '$titolo'
                      and Autore = '$artista'";
        $risultato1 = $conn->query($controllo);
        //se la canzone esiste prosegue altrimenti da errore
        if($risultato1->num_rows > 0) {
            //Tramite la query di prima prende id della canzone e lo mette in una variabile
            $row = $risultato1->fetch_assoc();
            $idCanzone = $row['id'];

            //Crea un collegamento tra la playlist e la canzone creando un nuovo dato nella tabella contiene inserendo l'id della canzone e il titolo della playlist
            $query_sql = "INSERT INTO  
                    contiene (fk_idCanzone,fk_titoloPlaylist) 
                    VALUES ($idCanzone, '$TitoloPlaylist');";
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
        }else{
            echo "Canzone non trovata nel database";
        }
        
    ?>