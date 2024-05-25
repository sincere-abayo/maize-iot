<?php
$conn=mysqli_connect("localhost","root","","maize") or die("failed to db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the table
$sql = "SELECT d_temp, d_hum FROM dht order by d_id desc limit 5";
$result = $conn->query($sql);
$sql1 = "SELECT * FROM ac order by a_id desc limit 1";
$result1 = $conn->query($sql1);
$acdata=mysqli_fetch_array($result1);
echo $acdata['a_status'];
$i=1;
// Check if there are any results
if ($result->num_rows > 0) {
    
    echo "<table>";
    echo "<tr><th>id</th><th>Name</th><th>Age</th></tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" .$i++."</td><td>" . $row["d_temp"] . "</td><td>" . $row["d_hum"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the connection
$conn->close();
?>