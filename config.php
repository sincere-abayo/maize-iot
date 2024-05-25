<?php

$conn=mysqli_connect("localhost","root","","maize") or die("failed to db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

