<?php
session_start();
include('templates/header.php');
include('auth.php'); // database connection

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'your_database_name');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle + / - buttons
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['increase'])) {
        $productId = (int) $_POST['increase'];
        $_SESSION['cart'][$productId]++;
    } elseif (isset($_POST['decrease'])) {
        $productId = (int) $_POST['decrease'];
        $_SESSION['cart'][$productId]--;
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

// Display cart
echo '<h1>Your Cart</h1>';

if (!empty($_SESSION['cart'])) {
    $total = 0;
    echo '<div class="cart-list">';
    
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        // Fetch product info
        $stmt = $conn->prepare("SELECT name, price FROM food_items WHERE id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $subtotal = $row['price'] * $quantity;
            $total += $subtotal;

            echo '
            <div class="cart-item">
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>Price: $' . number_format($row['price'], 2) . '</p>
                <p>Quantity: ' . $quantity . '</p>
                <p>Subtotal: $' . number_format($subtotal, 2) . '</p>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="increase" value="' . $productId . '">+</button>
                </form>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="decrease" value="' . $productId . '">-</button>
                </form>
            </div>';
        }
        $stmt->close();
    }
    
    echo '</div>';
    echo '<h2>Total: $' . number_format($total, 2) . '</h2>';
} else {
    echo '<p>Your cart is empty.</p>';
}

$conn->close();
?>

<style>
.cart-list {
    margin-top: 20px;
}

.cart-item {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
}
</style>

<?php include('templates/footer.php'); ?>