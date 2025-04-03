<?php
// Percorso del file dove memorizzare i dati
$file_path = 'C:\\Users\\Anton\\OneDrive\\Desktop\\index\\dati.json';

// Recupera i dati dal modulo HTML
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$data = $_POST['data'];
$motivo = $_POST['motivo'];
$Squadriglia = $_POST['Squadriglia'];
$assenzeSq = isset($_POST['sq']) ? 1 : 0;
$assenzeReparto = isset($_POST['reparto']) ? 1 : 0;

// Leggi i dati esistenti dal file
$dati_esistenti = file_get_contents($file_path);
$dati_array = json_decode($dati_esistenti, true);

// Aggiungi i nuovi dati
$nuovi_dati = [
    "nome" => $nome,
    "cognome" => $cognome,
    "data" => $data,
    "motivo" => $motivo,
    "Squadriglia" => $Squadriglia,
    "assenzeSq" => $assenzeSq,
    "assenzeReparto" => $assenzeReparto
];
$dati_array[] = $nuovi_dati;

// Scrivi i dati aggiornati nel file
file_put_contents($file_path, json_encode($dati_array, JSON_PRETTY_PRINT));

echo "Dati salvati con successo<br>";
?>