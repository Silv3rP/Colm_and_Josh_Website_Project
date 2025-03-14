<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    
</body>
</html>

<?php include 'templates/header.php'; ?>

<section id="menu">
    <h2>Our Menu</h2>
    <ul>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fastfood_db";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Clear existing items and insert the top 5 highest-rated items
        $sqlTop5 = "INSERT INTO menu_items (name, price, rating)
            SELECT name, price, rating 
            FROM (
                SELECT name, price, rating 
                FROM menu_items 
                ORDER BY rating DESC 
                LIMIT 5
            ) AS top_items";
        
        if ($conn->query("DELETE FROM menu_items") === TRUE) {
            if ($conn->query($sqlTop5) === TRUE) {
                echo "<p>Menu updated with top 5 highest-rated items!</p>";
            } else {
                echo "<p>Error inserting top items: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error clearing menu: " . $conn->error . "</p>";
        }
        
        // Display the updated table
        $result = $conn->query("SELECT name, price, rating FROM menu_items");
        
        if ($result->num_rows > 0) {
            echo "<h2>Top 5 Highest-Rated Menu Items</h2><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['name']} - \${$row['price']} (Rating: {$row['rating']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No menu items found.</p>";
        }
        
        // Close connection
        $conn->close();
        ?>
        
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
    <p>Address: 123 Food Street, Tasty Town</p>
</section>

<?php include 'templates/footer.php'; ?>
