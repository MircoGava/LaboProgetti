//Usato chat gpt per capire come fare questa parte
<?php
session_start();

if (isset($_GET['Titolo'])) {
    $_SESSION['Titolo'] = $_GET['Titolo'];
}


header("Location: playlist.php");
exit;
