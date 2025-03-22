<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Ensure correct path to User.php
require_once __DIR__ . '/classes/User.php';

$conn = new mysqli("localhost", "root", "", "los_boyos_hermanos", 3307);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$user = new User($conn);
$message = "";

// Handle Login
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userData = $user->login($email, $password);

    if ($userData) {
        $_SESSION["user_id"] = $userData["id"];
        $_SESSION["role"] = $userData["role"];

        if ($userData["role"] === "admin") {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $message = "Invalid credentials!";
    }
}

// Handle Signup
if (isset($_POST["signup"])) {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $role = "user"; // Default role

    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $role);

    if ($stmt->execute()) {
        $message = "Signup successful! Please log in.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle Logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: auth.php");
    exit();
}

$conn->close();
?>

<?php include 'templates/header.php'; ?>
<h1>Authentication</h1>
<p><?php echo $message; ?></p>

<button onclick="showLogin()">Login</button>
<button onclick="showSignup()">Signup</button>

<div id="loginForm">
    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button><br><br>
    </form>
</div>

<div id="signupForm" style="display: none;">
    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit" name="signup">Sign Up</button><br><br>
    </form>
</div>

<?php if (isset($_SESSION["user_id"])): ?>
    <a href="auth.php?logout=true">Logout</a>
<?php endif; ?>

<script>
    function showLogin() {
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("signupForm").style.display = "none";
    }

    function showSignup() {
        document.getElementById("signupForm").style.display = "block";
        document.getElementById("loginForm").style.display = "none";
    }
</script>

<?php include 'templates/footer.php'; ?>
