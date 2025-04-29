<?php

include('templates/header.php');  // Include the header template
include('auth.php');  // Include authentication and database connection

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'fastfood_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Stop if database connection fails
}

// Handle cart actions (increase/decrease quantity) and checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle increase or decrease quantity in cart
    if (isset($_POST['increase']) || isset($_POST['decrease'])) {
        $productId = (int) ($_POST['increase'] ?? $_POST['decrease']);
        $action = isset($_POST['increase']) ? 1 : -1;
        $_SESSION['cart'][$productId] = max(0, ($_SESSION['cart'][$productId] ?? 0) + $action);
        if ($_SESSION['cart'][$productId] == 0) unset($_SESSION['cart'][$productId]);  // Remove item if quantity is 0
    }

    // Handle checkout process
    if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
        $userId = $_SESSION['user_id'];  // Get the logged-in user's ID
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Get product details from the database
            $stmt = $conn->prepare("SELECT item_name, price FROM fast_food WHERE item_id = ?");
            $stmt->bind_param('i', $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $totalPrice = $row['price'] * $quantity;  // Calculate total price for the item
                // Insert the order into the database
                $insertStmt = $conn->prepare("INSERT INTO orders (user_id, item_id, quantity, total_price) VALUES (?, ?, ?, ?)");
                $insertStmt->bind_param('iiid', $userId, $productId, $quantity, $totalPrice);
                $insertStmt->execute();
                $insertStmt->close();
            }
            $stmt->close();
        }
        unset($_SESSION['cart']);  // Clear the cart after checkout
        echo "<p>Your order has been placed successfully!</p>";  // Success message after placing the order
    }
}

// Display cart contents
echo '<h1>Your Cart</h1>';
if (!empty($_SESSION['cart'])) {
    $total = 0;  // Initialize total price for all items
    echo '<div class="cart-list">';

    // Loop through each item in the cart
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        // Get product details (name and price)
        $stmt = $conn->prepare("SELECT item_name, price FROM fast_food WHERE item_id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $subtotal = $row['price'] * $quantity;  // Calculate subtotal for this item
            $total += $subtotal;  // Add to the total price

            // Display product details in the cart
            echo '
            <div class="cart-item">
                <h3>' . htmlspecialchars($row['item_name']) . '</h3>
                <p>Price: $' . number_format($row['price'], 2) . '</p>
                <p>Quantity: ' . $quantity . '</p>
                <p>Subtotal: $' . number_format($subtotal, 2) . '</p>
                <form method="POST" style="display:inline-block;">
                    <button type="submit" name="increase" value="' . $productId . '">+</button>
                </form>
                <form method="POST" style="display:inline-block;">
                    <button type="submit" name="decrease" value="' . $productId . '">-</button>
                </form>
            </div>';
        }
        $stmt->close();
    }

    echo '</div>';
    echo '<h2>Total: $' . number_format($total, 2) . '</h2>';  // Display total price

    // Checkout button
    echo '<form method="POST" style="display:inline-block;">
            <button type="submit" name="checkout">Checkout</button>
          </form>';
} else {
    echo '<p>Your cart is empty.</p>';  // Message when the cart is empty
}

$conn->close();  // Close the database connection
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
