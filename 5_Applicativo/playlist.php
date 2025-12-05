<?php
    require_once "mostraCanzoni.php";
    session_start();
    $printCanzoni = new mostraCanzoni;
?>

<!DOCTYPE html>
<html>
<head>
    <title>YourMusic</title>
    <link rel="stylesheet" href="css/playlist.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="d1">
        <h1 class="Titolo" >   <?php echo $printCanzoni->getTitolo(); ?>  </h1>
    </div>
    <div style="display: flex;">
        <div class="d2"  >
            <?php echo $printCanzoni->AggiungiCanzoni(); ?>
            <?php echo $printCanzoni->RimmuoviCanzoni(); ?>
            <button href="#" onclick="indietro()" class="OtherButton"><-</button>
        </div>
        <div class="d3" >
            <table border="1">
                <tr>
                    <th scope="col">Titolo</th>
                    <th scope="col">Artista</th>
                    <th scope="col">Album</th>
                </tr>
                <?php
                echo $printCanzoni->mostraCanzoni();
                ?>
            </table>      
        </div>
        <div class="box center">
        <div class="box-1 center">
                <h4 id="name"></h4>
                <div class="art">
                    <img class="center" id="artist" src="" alt="">
                </div>
                <div class="art-name">
                    <p class="title"></p>
                </div>
                <div class="prog">
                    <div class="time">
                        <div class="start">
                            <p id="start">0:00</p>
                        </div>
                        <div class="end">
                            <p id="end">0:00</p>
                        </div>
                    </div>

                    <div class="line">
                        <div class="lineChild"></div>
                    </div>

                </div>
                <div class="msc center">
                    <div class="ctrl center" onclick="backward()">
                        <i class="fa-solid fa-backward-step"></i>
                    </div>
                    <div class="ctrl center" id="playsong">
                        <i class="fa-solid fa-play" id="Tplay"></i>
                        <i class="fa-solid fa-pause none" id="Tpause" style="display: none;"></i>
                    </div>
                    <div class="ctrl center" onclick="forward()">
                        <i class="fa-solid fa-forward-step"></i>
                    </div>
                    <audio src="" class="song"></audio>
                </div>
            </div>

    <script src="javaScript/playlist.js">
   
    </script>
    


</body>
</html>