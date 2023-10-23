<?php
    session_start();
    echo "Thank you for using our website " . $_SESSION['user_name'] . "!";
    session_unset();
    session_destroy();
    echo "<br><a href='index.html'>Go back to the login page</a>";
?>

