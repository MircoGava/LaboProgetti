
    <?php
    class visualizza{

    
    function visualizzaPlay(){
        //Prende e rende utilizzabile su questa pagina la variabile username
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        $username = $_SESSION['username'];


        //connessione al database
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }
        //seleziona tutte le playlist presenti sul database, ma solo quelle legate all'user
        $query_sql = "select * from playlist where fk_username = '$username'";

        $risultato = $conn->query($query_sql);

        //Le trasfroma in variabili che vengono poi usate per venire printate
        while ($riga = $risultato->fetch_assoc()){
            $TitoloPlaylist = $riga["Titolo"];
            $Bio = $riga["Bio"];
            
            //Ogni playlist che puoi vedere ha anche una piccola funzione al suo interno, che quando la premi puoi entrare dentro la playlist.
            //La funzione serve anche a portare la variabile nel file php di cui si è già parlato in precedenza, in modo che la funzione del file riproduttore selezioni 
            //solo le canzoni di quella playlist, il relocate serve ad andare nel html del riproduttore per ascoltare tutte le canzoni
            echo "<tr><td onclick=\"window.location.href='setPlaylist.php?TitoloPlaylist=$TitoloPlaylist'\"> $TitoloPlaylist</td><td> $Bio </td></tr>";
            
        }

            
    }

    function visualizzaUsername()
    {
        

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        
        return $_SESSION['username'];
    }
}
    
    ?>

