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

fetch('./Connessione.php')
  .then(res => res.json())
  .then(data => {
    artist_name = data.map(song => song.Autore);
    song_title = data.map(song => song.Titolo);

    lun_array = song_title.length - 1;

    

    playSong.addEventListener('click', effect);

    function effect(){
        if((!playing.classList.contains('none'))){
            canzone.play();
            DisPause.style.display = 'block';
            DisPlay.style.display = 'none';
            setInterval(prog,1000);
            setInterval(line,1000);

            progress.addEventListener('click', (e) => {
                const rect = e.target.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const percent = clickX / e.target.clientWidth;
                const newTime = percent * canzone.duration;
                canzone.currentTime = newTime;
            });

            function line() {
                var widthbar = (canzone.currentTime / canzone.duration) * 100;
                lines.style.width = widthbar + '%';
            }
        }
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

    function songs(x){
        art_name.innerHTML = artist_name[x];
        titolo.innerHTML = song_title[x];
        art_img.src = 'foto/' +  artist_name[x] + '.png';
        canzone.src = 'canzoni/' + song_title[x] + '.mp3';
        canzone.addEventListener('loadedmetadata', dur);
    }

    songs(0);

    const lines = document.querySelector('.lineChild');
    const progress = document.querySelector('.line');
    const strt = document.querySelector('#start');
    const end = document.querySelector('#end');

    function dur(){
        var dura = canzone.duration;
        var secdu = Math.floor(dura % 60);
        var mindu = Math.floor(dura / 60);
        if(secdu < 10){
            secdu = '0' + secdu;
        }
        end.innerHTML = mindu + ':' + secdu;
    }

    function prog(){
        var curTime = canzone.currentTime;
        var minCur = Math.floor(curTime / 60);
        var secCur = Math.floor(curTime % 60);

        if(secCur < 10){
            secCur = '0' + secCur;
        }
        strt.innerHTML = minCur + ':' + secCur;

        if(canzone.currentTime >= canzone.duration) {
            forward();
        }
    }

    
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



function indietro() {
    window.location.href = './home.php';
}