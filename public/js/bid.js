let placeBidBtn = document.getElementById("placeBidBtn");

if (placeBidBtn) {
    placeBidBtn.addEventListener("click", function() {
        let amount = document.getElementById("bidAmount").value;
        let listingId = document.getElementById("listingId").value;
        let message = document.getElementById("bidMessage");

        message.innerHTML = "";

        if (amount === "" || Number(amount) <= 0) {
            message.innerHTML = "Please enter a valid bid amount";
            message.style.color = "red";
            return;
        }

        let formData = new FormData();
        formData.append("listing_id", listingId);
        formData.append("amount", amount);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/Task-3/api/place_bid.php", true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if (response.ok) {
                    document.getElementById("currentBid").innerHTML = response.new_bid;
                    document.getElementById("bidCount").innerHTML = response.bid_count;

                    let bidHistory = document.getElementById("bidHistory");

                    let newRow = `
                        <tr>
                            <td>${response.bidder_name}</td>
                            <td>$${response.new_bid}</td>
                            <td>${response.time}</td>
                        </tr>
                    `;

                    bidHistory.insertAdjacentHTML("afterbegin", newRow);

                    message.innerHTML = "Bid placed successfully";
                    message.style.color = "green";

                    document.getElementById("bidAmount").value = "";
                } else {
                    message.innerHTML = response.error;
                    message.style.color = "red";
                }
            }
        };

        xhr.send(formData);
    });
}