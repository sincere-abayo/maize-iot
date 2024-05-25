

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
// SQL query to fetch data for the last 12 months
$sqlchart = "SELECT DATE_FORMAT(d_created_at, '%M') AS month, AVG(d_temp) AS avg_temperature, AVG(d_hum) AS avg_humidity
        FROM dht
        WHERE d_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY MONTH(d_created_at)
        ORDER BY MONTH(d_created_at)";

$resultchart = $conn->query($sqlchart);

// if ($resultchart->num_rows > 0) {
    $months = array();
    $temperatureData = array();
    $humidityData = array();

    while ($rowchart = $resultchart->fetch_assoc()) {
        $months[] = $rowchart['month'];
        $temperatureData[] = $rowchart['avg_temperature'];
        $humidityData[] = $rowchart['avg_humidity'];
    }

$id=$_SESSION['id'];

$stmt = $conn->query("SELECT * FROM profile WHERE p_id ='$id'");
$stmtdata=mysqli_fetch_array($stmt);
$name=$stmtdata[1];
$email=$stmtdata[2];
// $name=$stmtdata[1];
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preventing Maize Weevils By Using IOT">
    <meta name="keywords" content="admin, estimates, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <titl   e>Preventing Maize Weevils By Using IOT</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">
    <link rel="stylesheet" href="assets/css/style.css">

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

        .grid-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-gap: 20px;
    }

    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      background-color: #fff;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    /* AC Status Styles */
    .ac-status {
      background-color: #f2f2f2;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .ac-status p {
      font-size: 18px;
      margin-bottom: 10px;
    }

    #acStatus {
      font-weight: bold;
    }

  
        
            </style>
</head>
<body>
<div id="global-loader">
    <div class="whirly-loader"> </div>
</div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
                </li>
                <li class=""><a href="temp.php"><span> Temperature</span> </a></li>
                <li class=""><a href="humidity.php"><span> Humidity</span> </a></li>
                <li class=""><a href="ACstatus.php"><span> AC Status</span> </a></li>
                <li class=""><a href="accont.php"><span> Accounts</span> </a></li>
                <!-- <li class=""><a href="feedback.php"><span> Feedback</span> </a></li> -->
            </ul>
        </div>
    </div>
</div>


<div class="page-wrapper">
    <div class="header">
        <div class="header-left active">
            <a href="index.php" class="logo">
                <img src="assets/img/maize.jpg" alt="">
            </a>
            <!-- <a id="toggle_btn" href="javascript:void(0);"></a> -->
        </div>

        <div class="user-menu">
            <div class="user-img">
                <img src="assets/img/profiles/avator1.jpg" alt="" id="userDropdown" onclick="toggleUserDropdown()">
                <span class="status online"></span>
            </div>
            <div class="user-info dropdown" id="userDropdownMenu" style="display: none;">
                <h5 class="user-name"><?php  echo $name  ?></h5>
                <span class="status online">Admin</span>
                <!-- <div class="dropdown-menu"> -->
                    <ul>
                
                        <li class=""><a href="accont.php"></i><span> My profile</span> </a></li>
                        <li class=""><a href="logout.php"></i><span> Log out</span> </a></li>
                    </ul>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <script>
        function toggleUserDropdown() {
            var dropdownMenu = document.getElementById("userDropdownMenu");
            dropdownMenu.style.display = dropdownMenu.style.display === "none" ? "block" : "none";
        }
    </script>

    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="row">
                        <div class="col-lg-7 col-sm-12 col-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header pb-0 d-flex justify-content-center align-items-right">
                                    <h5 class="card-title mb-0">Temperature and Humidity</h5>
                                    <div class="graph-sets">
                                     
                                        <div style="width: 80%; margin: 0 auto;">
                                            <canvas id="temperatureChart"></canvas>
                                        </div>
                                        <div style="width: 80%; margin: 20px auto;">
                                            <canvas id="humidityChart"></canvas>
                                        </div>
                                        <script>
                                            // Sample data for temperature and humidity
                                            const temperatureData = <?php echo json_encode($temperatureData); ?>;
        const months = <?php echo json_encode($months); ?>;

        var temperatureCtx = document.getElementById('temperatureChart').getContext('2d');
        var temperatureChart = new Chart(temperatureCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: temperatureData,
                    backgroundColor: 'red',
                    borderColor: 'red',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Humidity chart
        const humidityData = <?php echo json_encode($humidityData); ?>;

        var humidityCtx = document.getElementById('humidityChart').getContext('2d');
        var humidityChart = new Chart(humidityCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Humidity (%)',
                    data: humidityData,
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container">
    <div>
      <div class="card-header pb-0 d-flex justify-content-between align-items-right">
        <h4 class="card-title mb-0">Recently Added Report</h4>
        <div class="dropdown">
          <a href="javascript:void(0);" onclick="toggleDropdown()" aria-expanded="false" class="dropset">
            <i class="fa fa-ellipsis-v"></i>
          </a>
          <div id="dropdownMenu" class="dropdown-menu">
            <div class="table-responsive dataview">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; while($row = $result->fetch_array()) {
                     echo "<tr><td>" .$row[3]."</td><td>" . $row["d_temp"] . "</td><td>" 
                     . $row["d_hum"] . "</td></tr>"; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="ac-status">
        <h2>AC Status</h2>
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
    </div>
    </div>
  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById("dropdownMenu");
        if (dropdownMenu.style.display === "none") {
            dropdownMenu.style.display = "block";
        } else {
            dropdownMenu.style.display = "none";
        }
    }
</script>
<script>

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
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
