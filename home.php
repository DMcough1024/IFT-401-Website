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
            // Create an array for the device ID's
            $device_ids = array();
            $device_names = array();
            echo "<table border='1'>";
            echo "<tr><th>Device ID</th><th>Device Type</th><th>Device Name</th></tr>";
            while($row = $result->fetch_assoc()) {
                array_push($device_ids, $row['serial_num']);
                array_push($device_names, $row['nickname']);
                echo "<tr><td>" . $row['serial_num'] . "</td><td>" . $row['model_name'] . "</td><td>" . $row['nickname'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        echo "<br>";
    ?>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $device_id = $_POST['device_id'];
            $sql_inner = "SELECT * FROM logs WHERE device_id='" . $device_id . "' ORDER BY logged_at DESC LIMIT 1";
            $result_inner = $conn->query($sql_inner);
            if ($result_inner->num_rows > 0) {
                while($row_inner = $result_inner->fetch_assoc()) {
                    echo $device_names[array_search($device_id, $device_ids)] . " " . $row_inner['logged_temp'] . " " . $row_inner['logged_at'] . "<br>";
                }
            } else {
                echo "0 results";
            }
        }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="device_id">Device ID:</label>
        <select name="device_id" id="device_id">
            <?php
                foreach ($device_ids as $device_id) {
                    echo "<option value='" . $device_id . "'>" . $device_names[array_search($device_id, $device_ids)] . "</option>";
                }
            ?>
        </select>
        <input type="submit" name="submit" value="Get Last Logged Temperature">
    </form>
</body>