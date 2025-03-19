<?php include 'templates/header.php'; 



session_start();

require_once 'classes/User.php'; // Link User.php

$conn = new mysqli("localhost", "root", "", "los_boyos_hermanos", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = new User($conn); // Create User object

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userId = $user->login($email, $password); // Use the User class to handle login

    if ($userId) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $userId;
        header("Location: index.php"); // Redirect to home page
        exit();
    } else {
        echo "<p style='color: red;'>Invalid credentials!</p>";
    }
}

$conn->close();
?>

<h1>LOGIN</h1>
<form method="POST">
    <br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button><br><br>
</form>

<?php include 'templates/footer.php'; ?>