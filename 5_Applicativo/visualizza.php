
    <?php
    class visualizza{

    
    function visualizzaPlay(){
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        $query_sql = "select * from playlist";

        $risultato = $conn->query($query_sql);


        while ($riga = $risultato->fetch_assoc()){
            $TitoloPlaylist = $riga["Titolo"];
            $Bio = $riga["Bio"];

            echo "<h2 onclick=\"window.location.href='setPlaylist.php?TitoloPlaylist=$TitoloPlaylist'\"> $TitoloPlaylist | $Bio </h2>
            <script> function playlist() {
                window.location.href = './RiproduttoreCanzoni.html';
             } 
            </script>";
            
        }

            
    }
}
    
    ?>

