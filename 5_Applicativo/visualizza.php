
    <?php
    class visualizza{

    
    function visualizzaPlay(){
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        $query_sql = "select * from playlist";

        $risultato = $conn->query($query_sql);

       

        echo "<p>Le playlist presenti sono: </p>";

        while ($riga = $risultato->fetch_assoc()){
            $Titolo = $riga["Titolo"];
            $Bio = $riga["Bio"];


            echo "Titolo: $Titolo <br>";
            echo "Bio: $Bio <br>";
        }
    }
}
    
    ?>

