
<?php
include 'config.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="styles.css">

<style>
    .container {
    max-width: 800px;
    margin: 50px auto;
    text-align: center;
    background-color: #f0f0f0; /* Background color */
    padding: 20px;
    border-radius: 10px;
}

h1 {
    margin-bottom: 20px;
}

.form-container {
    display: inline-block;
    background-color: #fff; /* Background color for the form container */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for the form container */
}

.profile-section {
    margin-bottom: 20px;
}

.profile-photo-label {
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.profile-photo-label img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

.edit-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: #007bff;
    color: #fff;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    cursor: pointer;
}

.account-details {
    text-align: left;
}

.account-details label {
    font-weight: bold;
}

.account-details input,
.account-details select,
.account-details button {
    margin-top: 10px;
    font-size: 16px;
    padding: 5px;
}

.account-details button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.account-details button:hover {
    background-color: #0056b3;
}

.button-container {
    margin-top: 20px;
}

.account-details {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .profile-section {
            font-size: 24px;
            margin-bottom: 15px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        .btn:hover {
            background-color: #45a049;
        }
</style>
</head>
<body>
<div class="container">
    <h1>Welcome in Maize weeivels prevention dashboard</h1>
    <div class="form-container">
    <div class="account-details">
            <form id="accountForm" method="post">
                <div class="profile-section">
                    Login 
                </div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
                <button type="submit" class="btn edit-btn">Login</button>
            </form>
        </div>
    </div>
   
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];


   // Prepare the SQL statement to prevent SQL injection
   $stmt = $conn->query("SELECT * FROM profile WHERE p_email = '$email'and p_password= '$password'");
  

   if ($stmt->num_rows > 0) {
     $stmtdata=mysqli_fetch_array($stmt);
     $id=$stmtdata['p_id'];
     
    $_SESSION['id']=$id;
       echo "<script>alert('Login successful!')</script>";
       header("refresh:0.5;url=./index.php");

   }
    else {
        echo "<script>alert('credintial invalid!')</script>";

       }
   

   // Close the statement and connection
   $stmt->close();
}
?>

</body>
</html>