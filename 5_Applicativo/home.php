<?php
    require_once "visualizza.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/page.css" >
</head>
<body>
    <div class="d1">
        <h1 class="Titolo" >YourMusic</h1>
    </div>
    <div style="display: flex;">
        <div class="d2" >
            <button onclick="versoAggiuntaPlaylist();">+</button>
            <button onclick="versoRimmuoviPlaylist();">-</button>
            <button onclick="versoAddCanzone();">C</button>
        </div>
        <div class="d3">
            <table border="1">
                <tr>
                    <th class="th-titolo">Titolo</th>
                    <th class="th-bio">Descrizione</th>
                </tr>
            <?php
            $VisualizzaPlaylist = new visualizza;
            echo $VisualizzaPlaylist->visualizzaPlay();

            ?>      
            </table>
        
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