<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["datei"])) {
    $dateiName = $_FILES["datei"]["name"];
    $dateiTmpName = $_FILES["datei"]["tmp_name"];
    $dateiTyp = $_FILES["datei"]["type"];
    $dateiGroesse = $_FILES["datei"]["size"];

    // Überprüfe den Dateityp und die Dateigröße
    $erlaubteTypen = ['image/jpeg', 'image/png', 'application/pdf']; // Erlaubte Dateitypen
    $maxGroesse = 20 * 1024 * 1024; // Maximale Dateigröße (hier 20 MB)

    if (!in_array($dateiTyp, $erlaubteTypen) || $dateiGroesse > $maxGroesse) {
        die("Ungültiger Dateityp oder Dateigröße überschritten.");
    }

    // Ordner für hochgeladene Dateien
    $uploadOrdner = "hochgeladene_dateien/";

    // Prüfen, ob der Ordner existiert, falls nicht, erstellen
    if (!file_exists($uploadOrdner)) {
        mkdir($uploadOrdner, 0777, true);
    }

    // Pfad für die hochgeladene Datei im Zielordner
    $zielPfad = $uploadOrdner . $dateiName;

    // Datei in den Upload-Ordner verschieben
    if (move_uploaded_file($dateiTmpName, $zielPfad)) {
        echo "Die Datei wurde erfolgreich hochgeladen und im Ordner gespeichert.";

        // Verbindung zur Datenbank
        $dbHost = '10.35.46.233:3306';
        $dbUser = 'k232351_nichtkarim1337';
        $dbPass = 'DeineMutter11!';
        $dbName = 'k232351_Klausurdribbler';

        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }

        // Dateiinhalt auslesen
        $dateiInhalt = file_get_contents($zielPfad);
        $dateiInhalt = $conn->real_escape_string($dateiInhalt);

        // Vorbereiten und Ausführen der SQL-Anweisung
        $sql = "INSERT INTO dateien (name, typ, groesse, inhalt) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $dateiName, $dateiTyp, $dateiGroesse, $dateiInhalt);

        if ($stmt->execute()) {
            echo " Die Datei wurde erfolgreich in die Datenbank und im Ordner gespeichert.";
        } else {
            echo " Fehler beim Hochladen der Datei in die Datenbank: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Fehler beim Hochladen der Datei in den Ordner.";
    }
} else {
    echo "Keine Datei ausgewählt.";
}
?>
