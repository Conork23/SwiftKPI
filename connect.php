<?php

$connect = mysqli_connect("127.0.0.1", "root", "") or die("Could not connect to server");
mysqli_select_db($connect, "swift_warehouse") or die("Could not connect to database");

?>

