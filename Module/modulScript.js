document.addEventListener("DOMContentLoaded", function() {
    // Funktion, die vor dem Drucken aufgerufen wird
    window.onbeforeprint = function() {
        // Benachrichtigt den Benutzer, dass das Drucken nicht erlaubt ist
        alert('Drucken ist für dieses Dokument nicht erlaubt.');

        // Setzt den Inhalt des Body-Tags auf leer, um das Drucken zu verhindern
        document.body.innerHTML = '';
    };

    // Funktion, die nach dem Drucken aufgerufen wird
    window.onafterprint = function() {
        // Lädt die Seite neu, um den ursprünglichen Inhalt wiederherzustellen
        window.location.reload();
    };
});
