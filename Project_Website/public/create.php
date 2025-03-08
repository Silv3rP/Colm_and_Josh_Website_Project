<?php include "templates/header.php"; ?>

<link rel="stylesheet" href="css/style.css">

<h2>Add a user</h2>

<div class="form">
    <form method="post">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" required>
        
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" required>
        
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>
        
        <label for="age">Age</label>
        <input type="text" name="age" id="age">
        
        <label for="location">Location</label>
        <input type="text" name="location" id="location">
        <br>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
<br>
<a href="index.php">Back to home</a>
<br>



<?php include "templates/footer.php"; ?>
