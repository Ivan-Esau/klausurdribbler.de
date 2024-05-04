// In script.js
document.addEventListener("DOMContentLoaded", function() {
    var password = prompt("Bitte Passwort eingeben:");
    if(password !== "Flight!Mode") {
        alert("Falsches Passwort!");
        document.body.innerHTML = '';
    }
});
