
<?php
include 'config.php';
// SQL query to fetch data from the table
$sql = "SELECT d_temp FROM dht order by d_id desc limit 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$temp=$row["d_temp"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    text-align: center;
}

.temperature-display {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperature Page</title>
   
</head>
<body>
    <script>
        function fetchTemperature() {
   location.reload()
}
function home(){
        document.location.href='index.php';
    }

    </script>
    <div class="container">
        <h1>Temperature Monitoring</h1>
        <div class="temperature-display">
            <h2>Current Temperature:</h2>
            <p id="currentTemperature"><?php echo $temp;?> °C</p>

        </div>
        <button onclick="fetchTemperature()">Refresh</button>
        <button onclick="home()">Home</button>
   
    </div>


</body>
</html>

