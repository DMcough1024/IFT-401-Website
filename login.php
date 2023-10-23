<?php
$email = $_POST['email'];
$password = $_POST['password'];
// Establishing Database connection 
$host = "192.168.1.23:3306";
$username = "dmyerscough";
$password = "password";
$dbname = "app_users";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the user is present in the database
$sql = "SELECT * FROM users WHERE user_email='$email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    echo "<br> User found in the database";
    $row = $result->fetch_assoc();
    if ($row['user_password'] === $password) {
        echo "<br> Password is correct";
        // Start a session
        session_start();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_email'] = $row['user_email'];
        $_SESSION['user_name'] = $row['user_name'];
        // Redirect to the home page
        header("Location: home.php");
    } else {
        echo "<br> Password is incorrect";
    }
}
else {
    echo "<br> User not found in the database";
}
?>