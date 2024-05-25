<?php
include 'config.php';
session_start();
// Construct the SQL query
$query = "SELECT * FROM profile WHERE p_id = '$id'";

// Execute the query
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$email=$row['p_email'];
$name=$row['p_name'];
$password=$row['p_password'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
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

</style>
</head>
<body>
<div class="container">
    <h1>My Profile</h1>
    <div class="form-container">
        <div class="account-details">
            <form id="accountForm" method="post">
                <div class="profile-section">
                    <label for="profile-photo" class="profile-photo-label">
                        <img src="/assets/img/logo3.png" alt="">
                        <span class="edit-icon">&#9998;</span>
                    </label>
                    <input type="file" id="profile-photo-input" accept="image/*" style="display: none;">
                </div>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name ?>"><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email ?>"><br>
                <label for="username">password:</label>
                <input type="password" id="username" name="password" value="<?php echo $password ?>"><br>
            <br>
                <button type="submit" class="btn edit-btn">Save Changes</button>
            </form>
            
            <?php

include 'config.php';

// Escape user inputs for security
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Attempt update query
    $sql = "UPDATE profile SET p_name='$name', p_email='$email', p_password='$password' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert ('Record updated successfully')</script>";
   header("refresh:0.5; ");
    } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>alert ('Record not updated successfully')</script>";

    }
}
?>
        </div>
    </div>
    <div class="button-container">
        <button class="btn logout-btn" onclick="logout()">Logout</button>
    </div>
</div>
<script>
    function logout(){
        document.location.href='logout.php';
    }
</script>
</body>
</html>


