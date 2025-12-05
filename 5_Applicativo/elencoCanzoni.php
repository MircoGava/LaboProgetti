<?php

namespace M133\T1;

class Paesi
{
    public function generaElenco()
    {
        echo ' <p>Paese (opzionale)</p>
    <select name="nazione" size="1">
        <option ></option>
        <option value="Svizzera">Svizzera</option>
        <option value="Italia">Italia</option>
        <option value="Romania">Romania</option>
        <option value="Albania">Albania</option>
    </select>';
    }

}