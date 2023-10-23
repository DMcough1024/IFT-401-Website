<?php 
$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_name'];
?> 
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<header>
    <h2>Welcome <?php echo $username; ?></h2>
    <a href="logout.php">Logout</a>
</header>
<body>
    <?php
        echo "<br> Database: " . $_SESSION['user_db'];
    ?>
</body>