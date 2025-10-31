<?php
    require_once "visualizza.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="home.css" >
</head>
<body>
    <div class="d1">
        <h1 class="Titolo" onclick="versoRiproduttore()">YourMusic</h1>
    </div>
    <div style="display: flex;">
        <div class="d2"  id="blocchi">
            <button onclick="versoAggiuntaPlaylist();">+</button>
            <button onclick="versoRimmuoviPlaylist();">-</button>
            <button></button>
        </div>
        <div class="d3" id="blocchi">
        
            <?php
            $VisualizzaPlaylist = new visualizza;
            echo $VisualizzaPlaylist->visualizzaPlay();

            ?>      
        
        </div>
    </div>

    <script>
        function versoRiproduttore()
        {
            window.location.href = 'RiproduttoreCanzoni.html';
        }
        function versoAggiuntaPlaylist()
        {
            window.location.href = 'CreazionePlaylist.html';
        }
        function versoRimmuoviPlaylist()
        {
            window.location.href = 'ElliminaPlaylist.html';
        }
    </script>

</body>
</html>