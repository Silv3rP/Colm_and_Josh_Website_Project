<?php include 'templates/header.php'; ?>

<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Assuming user is logged in
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO shipping (user_id, full_name, address, city, postal_code, country, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $full_name, $address, $city, $postal_code, $country, $phone);
    
    if ($stmt->execute()) {
        $_SESSION['shipping_id'] = $conn->insert_id; // Save shipping ID for the order
        header("Location: payment.php"); // Redirect to payment
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h1>ENTER YOUR DETAILS HERE</h1>
<br>
<br>
<br>
<br>
<br>
<br>
<form method="post">
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="text" name="address" placeholder="Address" required>
    <input type="text" name="city" placeholder="City" required>
    <input type="text" name="postal_code" placeholder="Postal Code" required>
    <input type="text" name="country" placeholder="Country" required>
    <input type="text" name="phone" placeholder="Phone Number" required>

    <br>
    <br>
    <button type="submit">Proceed to Payment</button>
</form>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'templates/footer.php'; ?>
