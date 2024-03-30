// In script.js
document.addEventListener("DOMContentLoaded", function() {
    var password = prompt("Bitte Passwort eingeben:");
    if(password !== "KidBoo123!") {
        alert("Falsches Passwort!");
        document.body.innerHTML = '';
    }
});
