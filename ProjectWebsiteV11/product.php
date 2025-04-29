<?php
session_start();
include('templates/header.php');
include('auth.php'); // database connection

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'your_database_name'); // Replace with your database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding to cart (if a POST request is made)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = (int) $_POST['add_to_cart'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    exit(); // Important: stop the page from reloading
}

// Fetch and display products
$sql = "SELECT id, name, price FROM food_items"; // Adjust your table name if needed
$result = $conn->query($sql);

echo '<h1>Our Menu</h1>';
echo '<div class="product-list">';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '
        <div class="product" onclick="addToCart(' . $row['id'] . ')">
            <h3>' . htmlspecialchars($row['name']) . '</h3>
            <p>$' . number_format($row['price'], 2) . '</p>
        </div>';
    }
} else {
    echo '<p>No food items found.</p>';
}

echo '</div>';

$conn->close();
?>

<script>
// Click to add product to cart
function addToCart(productId) {
    const formData = new FormData();
    formData.append('add_to_cart', productId);

    fetch('product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Item added to cart!');
    })
    .catch(error => console.error('Error:', error));
}
</script>

<style>
.product-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product {
    border: 1px solid #ccc;
    padding: 20px;
    width: 220px;
    text-align: center;
    border-radius: 10px;
    background: #f9f9f9;
    cursor: pointer;
    transition: transform 0.2s, background-color 0.2s;
}

.product:hover {
    transform: scale(1.05);
    background-color: #e2e2e2;
}
</style>

<?php include('templates/footer.php'); ?>