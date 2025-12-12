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
    
        if($risultato1->num_rows > 0){
            $errori[] = "Questo username è già stato preso";
        }else {
        }
    } 

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            $errori[] = "La password deve essere di almeno 8 caratteri";
        }
        
        // Controlla almeno una lettera maiuscola
        if (!preg_match('/[A-Z]/', $password)) {
            $errori[] = "La password deve contenere almeno 1 carattere maiuscolo";
        }
        
        // Controlla almeno una lettera minuscola
        if (!preg_match('/[a-z]/', $password)) {
            $errori[] = "La password deve contenere almeno 1 carattere in minuscolo";
        }
        
        // Controlla almeno un numero
        if (!preg_match('/[0-9]/', $password)) {
            $errori[] = "La password deve contenere almeno 1 numero";
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
        <h2>Registrati</h2>

            <form method="post" >
                <p>Username:</p>
                <input type="text" name="username" placeholder="Username" required class="text">
                <p>Password:</p>
                <input type="password" name="password"  placeholder="Password" required class="text">
                <div class="center">
                <input type="submit"  name="invia" value="Invia" class="submit center" >
                </div>
            </form>
            <p style="border=1px">La password deve contenere almeno 8 caratteri, una maiuscola </p>
            <p>una minuscola e un numero</p>
            <?php if ($metodo === 'POST'): ?>
                <?php if (!empty($errori)): ?>
                    <div class="error">
                        <p><strong>Attenzione:</strong></p>
                        <ul>
                            <?php foreach ($errori as $msg): ?>
                                <li><?php echo $msg; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


<?php if ($metodo === 'POST'): ?>
    <?php



if ($metodo === 'POST') {

    // Raccogli dati
    $username = $_POST["username"];
    $password = strip_tags(addslashes($_POST['password']));
    // Connessione
    $conn = new mysqli("localhost","root","","yourmusic");
    if($conn->connect_error){
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Controlla se ci sono errori
    if (empty($errori)) {
        // Nessun errore: inserisci nel database
        $query_sql = "INSERT INTO account (username, password) VALUES ('$username', '$password')";
        $risultato = $conn->query($query_sql);

        if($risultato){
            echo "<script> window.location.href = 'login.php'; </script>";
            exit;
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