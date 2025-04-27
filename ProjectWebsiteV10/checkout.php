<?php include 'templates/header.php'; ?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['shipping_id'])) {
    header("Location: shipping.php");
    exit();
}

// Fetch shipping details
$conn = new mysqli("localhost", "root", "", "fastfood_db", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$shipping_id = $_SESSION['shipping_id'];
$sql = "SELECT * FROM shipping WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shipping_id);
$stmt->execute();
$shippingDetails = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<h1>Checkout</h1>
<h2>Shipping Details</h2>
<p>Name: <?php echo htmlspecialchars($shippingDetails['full_name']); ?></p>
<p>Address: <?php echo htmlspecialchars($shippingDetails['address']); ?></p>
<p>City: <?php echo htmlspecialchars($shippingDetails['city']); ?></p>
<p>Postal Code: <?php echo htmlspecialchars($shippingDetails['postal_code']); ?></p>
<p>Country: <?php echo htmlspecialchars($shippingDetails['country']); ?></p>
<p>Phone: <?php echo htmlspecialchars($shippingDetails['phone']); ?></p>

<h2>Order Summary</h2>
<p>Your order details will be displayed here.</p>

<h2>Payment</h2>
<form action="payment.php" method="POST">
    <label for="payment_method">Select Payment Method:</label>
    <select id="payment_method" name="payment_method" required>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
    </select>
    <br><br>
    <button type="submit">Complete Payment</button>
</form>

<?php include 'templates/footer.php'; ?>
