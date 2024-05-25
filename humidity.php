



<?php
include 'config.php';
// SQL query to fetch data from the table
$sql = "SELECT d_hum FROM dht order by d_id desc limit 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$hum=$row["d_hum"];
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

        .humidity-display {
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
    <title>Humidity Page</title>
</head>
<body>
    
    <div class="container">
        <h1>Humidity Monitoring</h1>
        <div class="humidity-display">
            <h2>Current Humidity :</h2>
            <p id="currentHumidity"><?php echo $hum;?> %</p>
        </div>
        <button onclick="fetchHumidity()">Refresh</button>
        <button onclick="home()">home</button>
    </div>

    <script>
        function fetchHumidity() {
   location.reload()
            
        }
        function home(){
        document.location.href='index.php';
    }

        // Call fetchHumidity function to update the current humidity periodically
        setInterval(fetchHumidity, 5000); // Update every 5 seconds (5000 milliseconds)
    </script>
</body>
</html>
