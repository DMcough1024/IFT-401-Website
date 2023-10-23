<head>
    <title>Login Script</title>
</head>
<?php
$email = $_POST['email'];
$password = $_POST['password'];
// Establishing Database connection 
$host = "192.168.1.23:3306";
$dbun = "dmyerscough";
$dbpw = "password";
$dbname = "app_users";
$conn = new mysqli($host, $dbun, $dbpw, $dbname);
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
        // if $password === 'password' redirect to a change password page
        // Start a session
        session_start();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_email'] = $row['user_email'];
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['user_db'] = $row['database'];
        $_SESSION['user_perm'] = $row['permission'];
        // Redirect to the home page
        header("Location: home.php");
        $conn->close();
     } else {
        echo "<br> Password is incorrect";
        echo "<br><a href='index.html'>Go back to the login page</a>";
        $conn->close();
    }
}
else {
    echo "<br> User not found in the database";
    echo "<br><a href='register.html'>Register a new user</a>";
    $conn->close();
}
?>
