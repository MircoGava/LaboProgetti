//Richiama le funzioni create nel html:
const canzone = document.querySelector('.song');
const playing = document.querySelector('.fa-play');
const pauses = document.querySelector('.fa-pause');
const forw = document.querySelector('.fa-forward-step');
const titolo = document.querySelector('.title');
const art_img = document.querySelector('#artist');
const art_name = document.querySelector('#name');
const playSong = document.querySelector('#playsong');

const DisPlay = document.getElementById('Tplay');
const DisPause = document.getElementById('Tpause');

var x = 0;
var artist_name = [];
var song_title = [];
var lun_array = 0;

//riempe gli array con le canzoni e i nomi degli artisti
fetch('./Connessione.php')
  .then(res => res.json())
  .then(data => {
    artist_name = data.map(song => song.Autore);
    song_title = data.map(song => song.Titolo);
    song_url   = data.map(song => song.Url);

    lun_array = song_title.length - 1;

    

    playSong.addEventListener('click', effect);

    //Funzione che parte quando si ascolta una canzone: permette alla barra di funzionare e alla musica di partire
    function effect(){
        if((!playing.classList.contains('none'))){
            canzone.play();
            DisPause.style.display = 'block';
            DisPlay.style.display = 'none';
            setInterval(prog,1000);
            setInterval(line,1000);

            //Codice che permette alla barra della musica di funzionare: quando premi ti sposta a quel tempo della canzone
            progress.addEventListener('click', (e) => {
                const rect = e.target.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const percent = clickX / e.target.clientWidth;
                const newTime = percent * canzone.duration;
                canzone.currentTime = newTime;
            });

            // Permette alla barra di ascolto di muoversi in base a che tempo della canzone sei
            function line() {
                var widthbar = (canzone.currentTime / canzone.duration) * 100;
                lines.style.width = widthbar + '%';
            }
        }
        //Permette alla canzone di mettersi in pausa
        else{
            canzone.pause();
            DisPause.style.display = 'none';
            DisPlay.style.display = 'block';
        }

        titolo.classList.toggle('run');
        playing.classList.toggle('none');
        pauses.classList.toggle('none');
        art_img.classList.toggle('round');
        dur();
    }
    //Rimmuove tutti gli effetti: azzera il tempo toglie l'immagine la canzone che stava suonando e cambia l'immagine della pausa 
    //Richiamata dalle funzioni che permettono di mandare avanti o tornare indietro
    function removeEffect(){
        canzone.pause();
        canzone.currentTime = 0.01;
        titolo.classList.remove('run');
        playing.classList.remove('none');
        pauses.classList.add('none');
        art_img.classList.remove('round');
        DisPause.style.display = 'none';
        DisPlay.style.display = 'block';
    }

    //carica la conzone giusta, con la sua immagine e la sua immagine, poi carica la durata
    function songs(x){
        art_name.innerHTML = artist_name[x];
        titolo.innerHTML = song_title[x];
        song_cover = data.map(song => song.Cover);
        art_img.src = song_cover[x];
        var song_url = data.map(song => song.Url);
        canzone.src = song_url[x];
        canzone.addEventListener('loadedmetadata', dur);
    }

    songs(0);

    const lines = document.querySelector('.lineChild');
    const progress = document.querySelector('.line');
    const strt = document.querySelector('#start');
    const end = document.querySelector('#end');

    //Mette la durata della canzone alla destra della barra di ascolto
    function dur(){
        var dura = canzone.duration;
        var secdu = Math.floor(dura % 60);
        var mindu = Math.floor(dura / 60);
        if(secdu < 10){
            secdu = '0' + secdu;
        }
        end.innerHTML = mindu + ':' + secdu;
    }

    //Mette a che putno della canzone è
    function prog(){
        var curTime = canzone.currentTime;
        var minCur = Math.floor(curTime / 60);
        var secCur = Math.floor(curTime % 60);

        if(secCur < 10){
            secCur = '0' + secCur;
        }
        strt.innerHTML = minCur + ':' + secCur;

        //Se la canzone finisce passa direttamente alla prossima
        if(canzone.currentTime >= canzone.duration) {
            forward();
        }
    }

    //Cambia canzone e passa a quella prima nella lista
    function backward(){
        const wasPlaying = !canzone.paused;
        x -= 1;
        if(x < 0){
            x = lun_array;
        }
        songs(x);
        dur();

        if (wasPlaying) {
            canzone.play();
        } else {
            removeEffect(); 
        }
    }

    //Cambia canzone e mette quella davanti a lui
    function forward(){
        const wasPlaying = !canzone.paused;
        x += 1;
        if(x > lun_array){
            x = 0;
        }
        songs(x);
        dur();

        if (wasPlaying) {
            canzone.play();
        } else {
            removeEffect(); 
        }
    }

    
    window.backward = backward;
    window.forward = forward;
    window.indietro = indietro;

})


//Permette al tasto in alto a sinistra dello schermo a portarti alla home page
function indietro() {
    window.location.href = './home.php';
}