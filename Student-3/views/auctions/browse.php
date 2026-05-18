<?php require_once __DIR__ . '/../partials/header.php'; ?>

<h1>Auction Browse</h1>

<div class="filter-box">

    <select id="categoryFilter">

        <option value="">All Categories</option>

        <?php foreach ($categories as $category) { ?>

            <option value="<?php echo $category['id']; ?>">
                <?php echo $category['name']; ?>
            </option>

        <?php } ?>

    </select>

    <input type="text" id="searchBox" placeholder="Search auction by title...">

</div>

<div id="listingContainer" class="listing-grid">

    <?php foreach ($listings as $listing) { ?>

        <div class="auction-card">

            <img src="/Task-3/Student-3/public/uploads/<?php echo $listing['image_path']; ?>">

            <h3><?php echo $listing['title']; ?></h3>

            <p>Category: <?php echo $listing['category_name']; ?></p>

            <p>
                Current Bid:
                <strong>$<?php echo $listing['current_bid']; ?></strong>
            </p>

            <p>
                Bid Count:
                <strong><?php echo $listing['bid_count']; ?></strong>
            </p>

            <p>
                Time Remaining:
                <span class="countdown"
                      data-end="<?php echo $listing['end_datetime']; ?>">
                </span>
            </p>

            <a class="btn"
               href="/Task-3/Student-3/index.php?page=detail&id=<?php echo $listing['id']; ?>">
                View Details
            </a>

        </div>

    <?php } ?>

</div>

<script src="/Task-3/Student-3/public/js/browse.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>