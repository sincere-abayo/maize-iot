<?php
// echo "well";
$conn=mysqli_connect("localhost","root","","maize") or die("failed to db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // Get the POST data
$name = $_POST['temperature'];
$age = $_POST['humidity'];
$status = $_POST['status'];
$date=date('Y-m-d H:i:s');

// // Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO dht (d_temp, d_hum,d_created_at) VALUES (?,?,?)");
$stmt->bind_param("sss", $name, $age,$date);
$stmt1 = $conn->prepare("INSERT INTO ac (a_status,a_created_at) VALUES (?,?)");
$stmt1->bind_param("ss", $status,$date);

// Execute the SQL statement
if ($stmt->execute() && $stmt1->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$stmt1->close();
$conn->close();
?>