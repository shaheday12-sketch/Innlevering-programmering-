<?php
// Databaseinnstillinger
$host = "b-studentsql-1.usn.no";
$user = "shayo1243";
$pass = "5791shayo1243";
$db   = "shayo1243";

// Forsøk å koble til databasen
$conn = new mysqli($host, $user, $pass, $db);

// Sjekk om tilkoblingen fungerer
if ($conn->connect_error) {
    // Feilmelding til utvikler, ikke bruk dette på en live nettside
    die("Tilkoblingsfeil: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

// Sett korrekt tegnsett
if (!$conn->set_charset("utf8mb4")) {
    // Gi beskjed hvis tegnsett ikke kan settes
    die("Feil ved innstilling av tegnsett: " . $conn->error);
}

// Hvis alt fungerer
echo "Koblet til databasen!";

// NB: Ingen avsluttende PHP-tagg for å unngå utilsiktet whitespace
