//Usato chat gpt per capire come fare questa parte
<?php
session_start();

if (isset($_GET['TitoloPlaylist'])) {
    $_SESSION['TitoloPlaylist'] = $_GET['TitoloPlaylist'];
}


header("Location: RiproduttoreCanzoni.html");
exit;
