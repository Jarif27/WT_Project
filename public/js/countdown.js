function updateCountdowns() {
    let countdowns = document.querySelectorAll(".countdown");

    countdowns.forEach(function(item) {
        let endTime = new Date(item.getAttribute("data-end")).getTime();
        let now = new Date().getTime();

        let distance = endTime - now;

        if (distance <= 0) {
            item.innerHTML = "Ended";
            return;
        }

        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        item.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
    });
}

setInterval(updateCountdowns, 1000);
updateCountdowns();