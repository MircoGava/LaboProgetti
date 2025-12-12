
<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/stats.css" >
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <div style="display: flex;">
        <button href="#" onclick="indietro()" class="fa-solid fa-arrow-left"></button>
        <div class="d1">
            <h1 class="Titolo" >Statistiche</h1>
        </div>
    </div>
    <div style="display: flex;">
        <div class="d2">
            <table>
                <tr>
                    <th class="th-nome">Canzone preferita</th>
                </tr>   
            </table>
            <canvas id="canzoneStats" style="width:800px;max-width:900px"></canvas>
        </div>
        <div class="d2">
            <table>
                <tr>
                    <th class="th-nome">Artista preferito</th>
                </tr>   
            </table>
            <canvas id="artistiStats" style="width:800px;max-width:900px"></canvas>
        </div>
    </div>
    
    <?php
        //Prende il nome dell'utente dalle variabili locali
        session_start();
 
        if (!isset($_SESSION['username'])) {
            echo json_encode(["error" => "Username non trovato"]);
            exit;
        }
        $username = $_SESSION['username'];

        //Collegamento al DB
        $conn = new mysqli("localhost","root","","yourmusic" );

        if($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
        }

        //Query che prende il nome degli autori e il numero di volte che ci sono
        //Prende massimo 5 valori e solo di quell'user
        $controlloAutore = "
        SELECT ca.autore, COUNT(*) AS totale 
        FROM contiene co
        INNER JOIN canzone ca ON co.fk_idCanzone = ca.id
        WHERE co.fk_username = '$username'
        GROUP BY ca.autore
        ORDER BY totale DESC
        LIMIT 5";

    // Esegui query
    $risultatoAutore = $conn->query($controlloAutore);
    
    //Riempe l'array con il risultato della query
    $artisti = [];
    if ($risultatoAutore && $risultatoAutore->num_rows > 0) {
        while ($row = $risultatoAutore->fetch_assoc()) {
            $artisti[] = $row;
        }
    }

    //Query che prende il titolo delle canzoni e il numero di volte che ci sono
    //Prende massimo 5 valori e solo di quell'user
    $controlloCanzone = "
        SELECT ca.titolo, COUNT(*) AS totale
        FROM contiene co
        INNER JOIN canzone ca ON co.fk_idCanzone = ca.id
        WHERE co.fk_username = '$username'
        GROUP BY ca.titolo
        ORDER BY totale DESC
        LIMIT 5";

    // Esegui query
    $risultatoCanzone = $conn->query($controlloCanzone);

    //Riempe l'array con il risultato della query
    $canzoni = [];
    if ($risultatoCanzone && $risultatoCanzone->num_rows > 0) {
        while ($row = $risultatoCanzone->fetch_assoc()) {
            $canzoni[] = $row;
        }
    }

    $conn->close();
    ?>

    <script>
        //Funzione che permette al pulsante di tornare alla home
        function indietro()
        {
            window.location.href = 'home.php';
        }

        //Artista
        //Questa riga di codice serve a trasformare i dati di $artisti
        //(l'array in cui abbiamo inserito il risultato della query) in un file json
        //poi facciamo leggere il json alla variabile che potremo utilizzare in js
        const artistiPHP = <?php echo json_encode($artisti); ?>;
        console.log(artistiPHP);
        //Prendono i dati nel json
        const nomiArtisti = artistiPHP.map(a => a.autore);
        const values = artistiPHP.map(a => a.totale);

        //Crea la tabella 
        new Chart(document.getElementById('artistiStats'), {
        type: "bar",
        data: {
            labels: nomiArtisti,
            datasets: [{
                backgroundColor: ["red", "MistyRose", "blue", "orange", "purple"],
                data: values
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 17, 
                        },
                        color: 'black' 
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 14, 
                        },
                        color: 'black'
                    }
                }
            }
        }
    });

    //Canzone
    const canzoniPHP = <?php echo json_encode($canzoni); ?>;
    console.log(canzoniPHP);

    const nomiCanzoni = canzoniPHP.map(a => a.titolo);
    const valuesCanzoni = canzoniPHP.map(a => a.totale);

    new Chart(document.getElementById('canzoneStats'), {
        type: "bar",
        data: {
            labels: nomiCanzoni,
            datasets: [{
                backgroundColor: ["pink", "yellow", "Aqua", "Lavender", "Lime"],
                data: valuesCanzoni
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 17, 
                        },
                        color: 'black' 
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 14, 
                        },
                        color: 'black'
                    }
                }
            }
        }
    });

    </script>
    


</body>
</html>