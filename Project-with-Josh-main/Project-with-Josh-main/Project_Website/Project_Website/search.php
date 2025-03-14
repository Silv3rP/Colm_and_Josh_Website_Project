<?php include 'templates/header.php'; ?>

<head>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<h2>Search Our Menu</h2>
<style>

h2{
text-align: center;

}
form{
text-align: center;
font-awesome

}
input{
padding:15px;

}
</style>
<form action="search.php" method="GET">
    <input type="text" name="query" placeholder="Enter a food item..." required>
    <button type="submit" class="search-button">
    <i class="fas fa-search"></i>
    

    </button>
    <br>
    <br>


</form>

<?php
if (isset($_GET['query'])) {
    $search = htmlspecialchars($_GET['query']);
    echo "<p>Showing results for: <strong>$search</strong></p>";
}
?>

<?php include 'templates/footer.php'; ?>
