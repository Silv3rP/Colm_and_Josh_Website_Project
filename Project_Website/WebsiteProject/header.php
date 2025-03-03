<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Los Boyos Hermanos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>Los Boyos Hermanos</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            
        </ul>
    </nav>

    <button onclick="toggleDarkMode()">🌙 Dark Mode</button>

<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
}
</script>
     
</header>
