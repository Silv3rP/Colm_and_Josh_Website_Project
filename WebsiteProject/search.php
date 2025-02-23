<?php include 'header.php'; ?>

<h2>Search Our Menu</h2>
<form action="search.php" method="GET">
    <input type="text" name="query" placeholder="Enter a food item..." required>
    <button type="submit">Search</button>
</form>

<?php
if (isset($_GET['query'])) {
    $search = htmlspecialchars($_GET['query']);
    echo "<p>Showing results for: <strong>$search</strong></p>";
}
?>

<?php include 'footer.php'; ?>
