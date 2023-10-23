<?php 
    session_start();
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['user_name'];
    $host = "192.168.1.23:3306";
    $dbun = "dmyerscough";
    $dbpw = "password";
    $dbname = $_SESSION['user_db'];
    $conn = new mysqli($host, $dbun, $dbpw, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
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
        $sql = "SELECT * FROM devices";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Device ID</th><th>Device Type</th><th>Device Name</th><th>Last Temperature</th><th>Last Log</th></tr>";
            while($row = $result->fetch_assoc()) {
                $sql_inner = "SELECT * FROM logs WHERE device_id=" . $row['serial_num'] . " ORDER BY logged_at DESC LIMIT 1";
                $result_inner = $conn->query($sql_inner);
                $row_inner = $result_inner->fetch_assoc();
                echo "<tr><td>" . $row['serial_num'] . "</td><td>" . $row['model_name'] . "</td><td>" . $row['nickname'] . "</td><td>" . $row_inner['logged_temp'] . "</td><td>" . $row_inner['logged_at'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    ?>
</body>