<?php include 'templates/header.php'; ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<h2>Search Our Menu</h2>

<style>
    h2 {
        text-align: center;
    }
    form {
        text-align: center;
    }
    input {
        padding: 15px;
    }
    .search-results {
        text-align: center;
        margin-top: 20px;
    }
    .hidden {
        display: none;
    }
</style>

<!-- Search Form -->
<form action="search.php" method="GET">
    <input type="text" name="query" placeholder="Enter a food item..." required>
    <button type="submit" class="search-button">
        <i class="fas fa-search"></i> Search
    </button>
</form>

<br>

<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "fastfood_db", 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the search query
$showShippingButton = false; // Flag to control button visibility

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    echo "<p class='search-results'>Showing results for: <strong>" . htmlspecialchars($search) . "</strong></p>";

    // Query to search the fast_food table
    $sql = "SELECT * FROM fast_food WHERE item_name LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='search-results'><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['item_name']) . " - $" . number_format($row['price'], 2) . "</li>";
        }
        echo "</ul></div>";
        $showShippingButton = true; // Show button when items are found
    } else {
        echo "<p class='search-results'>No results found for '$search'</p>";
    }
}

// Close the database connection
$conn->close();
?>

<!-- Proceed to Shipping Button (Only visible if search has results) -->
<?php if ($showShippingButton): ?>
    <a href="shipping.php" class="search-button">Proceed to Shipping</a>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>
