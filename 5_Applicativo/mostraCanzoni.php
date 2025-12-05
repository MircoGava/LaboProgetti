<?php
class mostraCanzoni {
    
    //Funzione che permette al titolo di cambiare in base a quale playlist ci si trova
    function getTitolo() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['TitoloPlaylist'])) {
            return "Playlist non selezionata";
        }
        
        return $_SESSION['TitoloPlaylist'];
    }
    //Funzione che mostra la lista delle canzoni
    function mostraCanzoni() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['TitoloPlaylist'])) {
            return "Playlist non selezionata";
        }
        
        $TitoloPlaylist = $_SESSION['TitoloPlaylist'];

        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        $username = $_SESSION['username'];
        
        // Connessione al database
        $conn = new mysqli("localhost", "root", "", "yourmusic");
        if ($conn->connect_error) {
            return "Connessione fallita: " . $conn->connect_error;
        }
        
        // Query con prepared statement
        $query_sql = "
            SELECT C.id, c.Titolo, c.Autore, c.Album
            FROM canzone AS c
            JOIN contiene AS co ON co.fk_idCanzone = c.id
            WHERE co.fk_titoloPlaylist = '$TitoloPlaylist'
            AND co.fk_username  = '$username' ";

        $risultato = $conn->query($query_sql);
        
        $output = "";
        if ($risultato->num_rows > 0) {
            while ($riga = $risultato->fetch_assoc()){
                $Autore = htmlspecialchars($riga["Autore"]);
                $Titolo = htmlspecialchars($riga["Titolo"]);
                $Album = htmlspecialchars($riga["Album"]);
                $output .= "<tr onclick=\"window.location.href='setSong.php?Titolo=$Titolo'\" ><td> $Titolo </td><td> $Autore</td><td>$Album </td></tr>";
            }
        } 

        $conn->close();
        
        return $output;
    }
    function AggiungiCanzoni(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['TitoloPlaylist'])) {
            return "Playlist non selezionata";
        }
        
        $TitoloPlaylist = $_SESSION['TitoloPlaylist'];
        echo "<button  class='OtherButton' onclick=\"window.location.href='setPlaylist2.php?TitoloPlaylist=$TitoloPlaylist'\">+</button>";
    }
    function RimmuoviCanzoni(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['TitoloPlaylist'])) {
            return "Playlist non selezionata";
        }
        
        $TitoloPlaylist = $_SESSION['TitoloPlaylist'];
        echo "<button  class='OtherButton' onclick=\"window.location.href='setPlaylist3.php?TitoloPlaylist=$TitoloPlaylist'\">-</button>";
    }
    
}