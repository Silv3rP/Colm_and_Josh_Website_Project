<?php include 'header.php'; ?>

<h2>Product Details</h2>

<?php
$product_name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Unknown Product";
echo "<h3>$product_name</h3>";
echo "<p>Description: This is a delicious meal from Los Boyo's Hermanos. Try it today!</p>";
echo "<p>Price: Varies</p>";
?>

<a href="index.php">Back to Home</a>

<?php include 'footer.php'; ?>
