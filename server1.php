<?php
// Percorso del file dove memorizzare i dati
$file_path = 'C:\\Users\\Anton\\OneDrive\\Desktop\\index\\dati_assenze.txt';

// Recupera i dati dal modulo HTML
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$data = $_POST['data'];
$motivo = $_POST['motivo'];
$Squadriglia = $_POST['Squadriglia'];
$assenzeSq = isset($_POST['sq']) ? 1 : 0;
$assenzeReparto = isset($_POST['reparto']) ? 1 : 0;

// Crea una stringa con i dati
$dati = "Nome: $nome, Cognome: $cognome, Data: $data, Motivo: $motivo, Squadriglia: $Squadriglia, Assenze Sq: $assenzeSq, Assenze Reparto: $assenzeReparto\n";

// Scrive i dati nel file
if (file_put_contents($file_path, $dati, FILE_APPEND | LOCK_EX)) {
    echo "Dati salvati con successo<br>";
} else {
    echo "Errore nel salvataggio dei dati<br>";
}

// Legge e visualizza i dati dal file
if (file_exists($file_path)) {
    $contenuto = file_get_contents($file_path);
    echo nl2br($contenuto);
} else {
    echo "Il file non esiste<br>";
}
?>
