<?php
$metodo = $_SERVER['REQUEST_METHOD'];

$username = "";
$password = "";

$errori = [];

// Se il form è stato inviato con POST
if ($metodo === 'POST') {

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
        $conn = new mysqli("localhost","root","","yourmusic");

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }
    
        $query_sql1 = "select * from account where username = '$username'";
    
        $risultato1 = $conn->query($query_sql1);
        //Verifica se il nome utente esiste e se la password è giusta, in caso contrario genera errore
        if($risultato1->num_rows != 1){
            $errori[] = "Nome utente inserito non valido";
        }else {
            $password = $_POST['password'];
            $query_sql2 = "select * from account where username = '$username' and password = '$password'";
            $risultato2 = $conn->query($query_sql2);
            if($risultato2->num_rows != 1){
                $errori[] = "La password è sbagliata";
            }
        }
    } 
}
?>
<!doctype html>
<html lang="it">
<head>
    <title>YourMusic</title>

    <link rel="stylesheet" href="css/account.css" >
<body>
    
    <div class="box center">
        <div class="box-1 center">
            <h2>LOGIN</h2>

            <form method="post" >
                <p>Username:</p>
                <input type="text" name="username" placeholder="Username" required class="text">
                <p>Password:</p>
                <input type="password" name="password" placeholder="Password" required class="text">
                <div class="center">
                <input type="submit"  name="invia" value="Invia" class="submit center" >
                </div>
            </form>
            <div class="center">
                <p>Non hai un account?</p>
            </div>
            <div class="center">
                <p onclick="registrati();"><b><u>Registrati</u></b></p>
            </div>
            <?php if ($metodo === 'POST'): ?>
                <?php if (!empty($errori)): ?>
                    <div class="error">
                        <p><strong>Attenzione:</strong></p>
                        <ul>
                            <?php foreach ($errori as $msg): ?>
                                <li><?php echo "<p>$msg</p>"; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        
        </div>
    </div>
    <script>
        function registrati() {
            window.location.href = 'registrati.php';
        }
    </script>


<?php if ($metodo === 'POST'): ?>
    <?php


if ($metodo === 'POST') {

    // Prendi i dati dal form
    $username = $_POST["username"];
    $password = $_POST["password"];


    //Connessione al db

    $conn = new mysqli("localhost","root","","yourmusic");

    if($conn->connect_error){
        die("Connessione fallita: " . $conn->connect_error);
    }
    if (empty($errori)) {
    //Verifica che non ci siano stati errori nell'inserimento della password e se non ci sono verifica se l'account esiste veramente
    $query_sql = "select * from account where username = '$username' and password = '$password'";

    $risultato = $conn->query($query_sql);

    if($risultato){
        //se l'account esiste ti porta in una pagina php che trasforma l'username in una variabile che verrà usata anche nel resto del codice
        //poi ti riporta direttamente nella home
        echo "<script> window.location.href='setUsername.php?username=$username'; </script>";
    } else {
        echo "Errore inserimento: " . $conn->error;
    }
}

    $conn->close();
}

?>

<?php endif; ?>

</body>
</html>