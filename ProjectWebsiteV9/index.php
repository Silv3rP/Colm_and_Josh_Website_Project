<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>

<?php include 'templates/header.php'; ?>

<section id="menu">
    <h2>Our Menu</h2>
    <ul>
        <?php

        require_once 'classes/User.php';

        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = '';
        $dbname = "fastfood_db";
        

        $conn = new mysqli($servername, $username, $password, $dbname, 3307);

        // Check connection
        if ($conn->connect_error) {
            die("<p style='color: red; '>Connection failed: " . $conn->connect_error);
        }

        // Fetch top 5 highest-rated items
        $sqlTop5 = "SELECT item_name, price, customer_rating FROM fast_food ORDER BY customer_rating DESC LIMIT 5";
        $result = $conn->query($sqlTop5);

        if ($result->num_rows > 0) {
            echo "<h2>Top 5 Highest-Rated Menu Items</h2>";
            echo "<ul>"; 
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['item_name']} - \${$row['price']} (Rating: {$row['customer_rating']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No menu items found.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </ul>
</section>

<section id="about">
    <h2>About Us</h2>
    <p>Welcome to Los Boyos Hermanos, where we serve delicious meals made fresh and fast! 
    Our goal is to provide quality food at affordable prices.</p>
</section>

<section id="contact">
    <h2>Contact Us</h2>
    <p>Email: contact@LosBoyosHermanos.com</p>
    <p>Phone: (123) 456-7890</p>
    <p>Address: <a href="https://google.com/maps">123 Food Street, Tasty Town</a></p>
</section>

<?php include 'templates/footer.php'; ?>

</body>
</html>
