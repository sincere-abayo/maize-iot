

<?php
include 'config.php';
session_start();
if (!isset($_SESSION['id'])) {
 header("location:./login.php");
}
// SQL query to fetch data from the table
$sql = "SELECT * FROM dht order by d_id desc limit 5";
$result = $conn->query($sql);
$sql1 = "SELECT * FROM ac order by a_id desc limit 1";
$result1 = $conn->query($sql1);
$acdata=mysqli_fetch_array($result1);
$acStatus=$acdata['a_status'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC Status Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    text-align: center;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
}

.ac-status {
    margin-top: 20px;
}

#acStatus {
    font-weight: bold;
}

#toggleButton {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

#toggleButton:hover {
    background-color: #218838;
}
.btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn1 {
            width: 20% !important;
          
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>AC Status</h1>
        <div class="ac-status">
        <?php
  if ($acStatus=="ON") {
   ?>
 
 <p>The AC is currently <span id="acStatus">turned ONN</span>.</p>
        <button id="toggleButton">Turn AC <span id="toggleButtonText">OFF</span></button>
     
   <?php
  } else {
   ?>

 
<p>The AC is currently <span id="acStatus">turned off</span>.</p>
        <button id="toggleButton">Turn AC <span id="toggleButtonText">On</span></button>
     
<?php
  }
  
       ?>
            <button onclick="home()" class="btn btn1">home</button>

            <!-- <button id="toggleAcButton" onclick="toggleAc()">Turn AC <span id="toggleButtonText">On</span></button> -->
        </div>
    </div>

    <script src="script.js"></script>

    <script>
  function home(){
        document.location.href='index.php';
    }
        const button = document.getElementById('toggleButton');
                const acStatusElement = document.getElementById('acStatus');
                let ledState = localStorage.getItem('ledState') || 'off';
        
                function updateUI() {
                    button.textContent = `Turn AC ${ledState === 'off' ? 'On' : 'Off'}`;
                    button.style.backgroundColor = ledState === 'off' ? 'green' : 'red';
                    acStatusElement.textContent = `${ledState}`;
                }
        
                updateUI();
        
                button.addEventListener('click', () => {
                    const newState = ledState === 'off' ? 'on' : 'off';
                    fetch(`toggle_led.php?action=${newState}`)
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            ledState = newState;
                            localStorage.setItem('ledState', newState);
                            updateUI();
                        })
                        .catch(error => console.error(error));
                });
            
            
                </script>
</body>
</html>
