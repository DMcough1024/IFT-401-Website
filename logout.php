<?php
    session_start();
    session_unset();
    session_destroy();
    echo "Thank you for using our website!";
    echo "<br><a href='index.html'>Go back to the login page</a>";
?>

