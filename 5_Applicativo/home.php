<?php
    require_once "visualizza.php";
    $VisualizzaPlaylist = new visualizza;
?>

<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/principale.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<body>
    <div class="d1">
        <h1 class="Titolo">YourMusic</h1>
    </div>
    <div style="display: flex;">
        <div class="d2" >
            <button onclick="versoAggiuntaPlaylist();">+</button>
            <button onclick="versoRimmuoviPlaylist();">-</button>
            <button onclick="versoStats();"  class="fa-solid fa-chart-simple"></button>
        </div>
        <div class="d3">
            <table border="1">
                <tr>
                    <th class="th-titolo">Titolo</th>
                    <th class="th-bio">Descrizione</th>
                </tr>
            <?php
            echo $VisualizzaPlaylist->visualizzaPlay();

            ?>      
            </table>
        
        </div>
    </div>
    <div class="d4">
        <h1>Account: <?php echo $VisualizzaPlaylist->visualizzaUsername(); ?> | <U><b onclick="Logout();">Logout</b></U></h1>
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
        function versoStats()
        {
            window.location.href = 'stats.php';
        }
        function Logout()
        {
            window.location.href = 'login.php';
        }
    </script>
    


</body>
</html>