<?php include 'templates/header.php'; ?>

<h2>Contact Us</h2>

<style>

h2{
text-align: center;

}

form{
text-align: center;

}



</style>

<form action="#" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <br>

    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    <br>
    <br>

    <button type="submit">Send</button>
    <br>
    <br>
</form>

<?php include 'templates/footer.php'; ?>
