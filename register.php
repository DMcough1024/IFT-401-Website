<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $client_id = $_SESSION['client_id'];
    $user_perm = $_SESSION['permission'];
    $user_db = $_SESSION['database'];
    $host = "192.168.1.23:3306";
    $dbun = "dmyerscough";
    $dbpw = "password";
    $dbname = "app_users";
    $conn = new mysqli($host, $dbun, $dbpw, $dbname);
    if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
    }
// Submitting the information to the DB
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_SESSION['client_id'])) {
	    echo "<p>Setting client variables</p>";
        } else {
	    $client_id = $_POST["client_id"];
	    $user_db = $_POST["database"];
	}
	$sql = "INSERT INTO app_users.users (user_name, user_email, user_phone, created_at, client_id, database, permission) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ssisiss", $p1, $p2, $p3, $p4, $p5, $p6, $p7);
	$p1 = $_POST["full_name"];
	$p2 = $_POST["email"];
	$p3 = $_POST["phone"];
	$p4 = new DateTime();
	$p5 = $client_id;
	$p6 = $user_db;
	$p7 = "user";
	if ($stmt->execute()) {
		echo "<p>Added user " . $_POST["full_name"] . "</p>";
	} else {
		echo "<p>Error: " . $stmt->error . "</p>";
	}
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
<h1>Add a new user</h1>
    <form action="" method="post">
    <p>Name: <input type="text" name="full_name" /></p>
    <p>Email: <input type="text" name="email" /></p>
    <p>Phone: <input type="int" name="phone" /></p>
    <p>Permission (admin/user): <input type="text" name="permission"/></p>
    <?php
	if(isset($_SESSION['client_id'])) {
	    echo "<p>Session exists</p>";
	    echo "<p>" . $_SESSION['client_id'] . "</p>";
	} else {
	    echo "<p>No Session</p>";
	    echo "<p>Client ID: <input type='int' name='client_id' /></p>";
	    echo "<p>Database: <input type='text' name='database' /></p>";
	}
    ?>
    <p>Add User<input type="submit"/></p>
    </form>
</body>
</html>
