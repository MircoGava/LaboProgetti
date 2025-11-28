<?php
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

        //Seleziona l'id della canzone che l'utente ha scelto
        $controllo = "SELECT id
                      FROM canzone
                      where Titolo = '$titolo'
                      and Autore = '$artista'";
        $risultato1 = $conn->query($controllo);
        //Controlla che quella canzone esiste, se esiste prosegue altrimenti printa che non l'ha trovata
        if($risultato1->num_rows > 0) {
            //Prende il valore di id dalla query di prima e lo trasforma in una variabile
            $row = $risultato1->fetch_assoc();
            $idCanzone = $row['id'];

            //Query che rimmuove dalla playlist una canzone 
            $query_sql = "DELETE FROM contiene 
            WHERE  fk_idCanzone = $idCanzone
            AND fk_titoloPlaylist = '$TitoloPlaylist' ";
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