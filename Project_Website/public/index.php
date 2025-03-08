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
        // Database Connection
        $conn = new mysqli("localhost", "root", "", "fastfood_db");

        // Check Connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Ensure the 'menu_items' table exists
        $createTableSQL = "CREATE TABLE IF NOT EXISTS menu_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(5,2) NOT NULL
        )";
        $conn->query($createTableSQL);

        // Insert default items if the table is empty
        $checkTable = $conn->query("SELECT COUNT(*) AS total FROM menu_items");
        $row = $checkTable->fetch_assoc();
        
        if ($row['total'] == 0) {
            $sqlInsert = "INSERT INTO menu_items (name, price) VALUES
                ('Spicy Chicken Sandwich', 5.99),
                ('BBQ Wings (6pcs)', 7.49),
                ('Loaded Fries', 4.99),
                ('Grilled Chicken Wrap', 6.99),
                ('Classic Burger', 8.99)";
            
            if ($conn->query($sqlInsert) === TRUE) {
                echo "<p>Menu items added!</p>";
            } else {
                echo "<p>Error inserting menu items: " . $conn->error . "</p>";
            }
        }

        // Fetch and Display Menu Items
        $sql = "SELECT name, price FROM menu_items";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row["name"]) . " - $" . number_format($row["price"], 2) . "</li>";
            }
        } else {
            echo "<li>No items available</li>";
        }

        // Close Connection
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
    <p>Address: 123 Food Street, Tasty Town</p>
</section>

<?php include 'templates/footer.php'; ?>
