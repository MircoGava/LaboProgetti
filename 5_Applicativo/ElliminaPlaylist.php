<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        $titolo = $_POST["Titolo"];

        $query_sql = "DELETE FROM playlist 
                    WHERE Titolo = '$titolo' ";

        $risultato = $conn->query($query_sql);

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