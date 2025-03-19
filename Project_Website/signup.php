
<?php include 'templates/header.php'; ?> 

<?php


$conn = new mysqli("localhost", "root", "", "los_boyos_hermanos", 3307);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");
    echo "Registered successfully!";
}

$conn->close();
?>

<h1>SIGNUP</h1>
<form method="POST">
    <br>
    Email: <input type="email" name="email" required><br><br>
 Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button><br><br>
</form>

<?php include 'templates/footer.php'; ?>