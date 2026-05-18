let categoryFilter = document.getElementById("categoryFilter");
let searchBox = document.getElementById("searchBox");
let listingContainer = document.getElementById("listingContainer");

categoryFilter.addEventListener("change", function() {
    let categoryId = categoryFilter.value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/Task-3/api/listings.php?category_id=" + categoryId, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            let listings = JSON.parse(xhr.responseText);
            renderListings(listings);
        }
    };

    xhr.send();
});

searchBox.addEventListener("keyup", function() {
    let q = searchBox.value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/Task-3/api/search.php?q=" + encodeURIComponent(q), true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            let listings = JSON.parse(xhr.responseText);
            renderListings(listings);
        }
    };

    xhr.send();
});

function renderListings(listings) {
    listingContainer.innerHTML = "";

    if (listings.length === 0) {
        listingContainer.innerHTML = "<p>No auctions found.</p>";
        return;
    }

    listings.forEach(function(listing) {
        let imagePath = listing.image_path ? listing.image_path : "no-image.jpg";

        let card = `
            <div class="auction-card">
                <img src="/Task-3/public/uploads/${imagePath}" alt="Auction Image">

                <h3>${listing.title}</h3>

                <p>Category: ${listing.category_name}</p>

                <p>Current Bid: <strong>$${listing.current_bid}</strong></p>

                <p>Bid Count: <strong>${listing.bid_count}</strong></p>

                <p>
                    Time Remaining:
                    <span class="countdown" data-end="${listing.end_datetime}"></span>
                </p>

                <a class="btn" href="/Task-3/views/auctions/detail.php?id=${listing.id}">
                    View Details
                </a>
            </div>
        `;

        listingContainer.innerHTML += card;
    });

    updateCountdowns();
}