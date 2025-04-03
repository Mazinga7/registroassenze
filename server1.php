<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mio_database";

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
echo "Connessione riuscita<br>";

// Crea il database se non esiste
$sql = "CREATE DATABASE IF NOT EXISTS mio_database";
if ($conn->query($sql) === TRUE) {
    echo "Database creato con successo<br>";
} else {
    echo "Errore nella creazione del database: " . $conn->error . "<br>";
}

// Seleziona il database
$conn->select_db($dbname);

// Crea la tabella se non esiste
$sql = "CREATE TABLE IF NOT EXISTS utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    data DATE NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    Squadriglia VARCHAR(100),
    assenzeSq TINYINT(1),
    assenzeReparto TINYINT(1),
    data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabella creata con successo<br>";
} else {
    echo "Errore nella creazione della tabella: " . $conn->error . "<br>";
}

// Recupera i dati dal modulo HTML
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$data = $_POST['data'];
$motivo = $_POST['motivo'];
$Squadriglia = $_POST['Squadriglia'];
$assenzeSq = isset($_POST['sq']) ? 1 : 0;
$assenzeReparto = isset($_POST['reparto']) ? 1 : 0;

// Query SQL per inserire i dati
$sql = "INSERT INTO utenti (nome, cognome, data, motivo, Squadriglia, assenzeSq, assenzeReparto) VALUES ('$nome', '$cognome', '$data', '$motivo', '$Squadriglia', '$assenzeSq', '$assenzeReparto')";
if ($conn->query($sql) === TRUE) {
    echo "Nuovo record creato con successo<br>";
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error . "<br>";
}

// Recupera i dati dal database
$sql = "SELECT id, nome, cognome, data, motivo, Squadriglia, assenzeSq, assenzeReparto, data_registrazione FROM utenti";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output dei dati di ogni riga
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nome: " . $row["nome"]. " - Cognome: " . $row["cognome"]. " - Data: " . $row["data"]. " - Motivo: " . $row["motivo"]. " - Squadriglia: " . $row["Squadriglia"]. " - Assenze Sq: " . $row["assenzeSq"]. " - Assenze Reparto: " . $row["assenzeReparto"]. " - Data di registrazione: " . $row["data_registrazione"]. "<br>";
    }
} else {
    echo "0 risultati<br>";
}

// Chiudi connessione
$conn->close();
?>