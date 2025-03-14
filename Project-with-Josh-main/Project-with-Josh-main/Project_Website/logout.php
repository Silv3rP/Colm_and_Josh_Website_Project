
<?php include 'templates/header.php'; ?> 

<div class="message">
    <?php
    session_start();
    session_destroy();
    echo "Logged out.";
    ?>
</div>

<style>
        .message {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
        }
</style>

<script> alert("Successfully logged out!"); </script>
<br>
<br>

<div class="a">
    
    <a href="login.php">Login Again</a>
    <br><br>

</div>

<style>
    .a{
        text-align: center;
        font-size: 20px;
        margin-top: 20px;
        color: #fff;

    }

</style>

<?php include 'templates/footer.php'; ?>