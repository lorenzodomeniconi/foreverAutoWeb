let countdownTime = 5;

const countdownElement = document.getElementById('countdown');
const interval = setInterval(() => {
    countdownTime--;
    countdownElement.textContent = countdownTime;
    if (countdownTime <= 0) {
        clearInterval(interval); // Ferma l'intervallo
        window.location.href = "index.php"; // Redirect alla home
    }
}, 1000); // Aggiorna ogni secondo