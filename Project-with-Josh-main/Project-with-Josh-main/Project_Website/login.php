<?php include 'templates/header.php'; ?> 


<?php
session_start();
$conn = new mysqli("localhost", "root", "", "los_boyos_hermanos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT id, password FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
}

$conn->close();
?>

<form method="POST">
    <br>
    Email: <input type="email" name="email" required><br><br>

    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button><br><br>
</form>



<?php include 'templates/footer.php'; ?>