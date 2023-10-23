<?php 
$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_name'];
?> 
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome <?php echo $username; ?></h1>
    <a href="logout.php">Logout</a>
</body>