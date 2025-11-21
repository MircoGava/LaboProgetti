<?php
    require_once "visualizza.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/home.css" >
</head>
<body>
    <div class="d1">
        <h1 class="Titolo" >YourMusic</h1>
    </div>
    <div style="display: flex;">
        <div class="d2"  id="blocchi">
            <button onclick="versoAggiuntaPlaylist();">+</button>
            <button onclick="versoRimmuoviPlaylist();">-</button>
            <button onclick="versoAddCanzone();">si</button>
        </div>
        <div class="d3" id="blocchi">
        
            <?php
            $VisualizzaPlaylist = new visualizza;
            echo $VisualizzaPlaylist->visualizzaPlay();

            ?>      
        
        </div>
    </div>

    <script>
        function versoAggiuntaPlaylist()
        {
            window.location.href = 'CreazionePlaylist.html';
        }
        function versoRimmuoviPlaylist()
        {
            window.location.href = 'ElliminaPlaylist.html';
        }
        function versoAddCanzone()
        {
            window.location.href = 'AggiungiCanzoni.php';
        }
    </script>
    


</body>
</html>