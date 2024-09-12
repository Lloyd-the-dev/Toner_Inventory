<?php
include "config.php";
session_start();
$userId = $_SESSION["user_id"];
$isAdmin = $_SESSION["isAdmin"];
$isCFO = $_SESSION["isCFO"];
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">

    <style>
        .heading{
            font-weight: 700;
            text-align: center;
            margin: 1rem;
            font-size: 2rem;
        }
        #userTable {
            margin: 50px auto 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
            color: black;
        }

        #userTable td, #userTable th {
            border: 1px solid #ddd;
            padding: 8px;
        }
 
        #userTable tr{
            background-color: white;
        }
        #userTable tr:hover {
            background-color: #ddd;
        }

        #userTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: dodgerblue;
            color: white;
        }
        #userTable a{
            color: black;
            text-decoration: none;
            text-transform: capitalize;

        }
        #userTable i{
            color: red;
            cursor: pointer;
        }
        .add-users{
            width: 40%;
            margin: 6rem auto;
        }
        .add-users h3{
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Navbar content -->
        <a class="navbar-brand" href="dashboard.php">TonerLOG</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link mr-8" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="toner.php">toners</a>
            </li>
            <?php 
                if($isAdmin){
            ?>
            <li class="nav-item active">
              <a class="nav-link" href="users.php">Users</a>
            </li>
            <?php } ?>
            <?php if($isAdmin || $isCFO) { ?>
            <li class="nav-item">
              <a class="nav-link" href="adminRequests.php">Requests</a>
            </li>
            <?php } ?>
            <?php
            if(!$isAdmin && !$isCFO){ 
            ?>
            <li class="nav-item">
              <a class="nav-link" href="requestToner.php">Request Toner</a>
            </li>
            <?php } ?> 
            <li class="nav-item">
              <a class="nav-link" href="edit_profile.php">Edit Profile</a>
            </li>   
            <li class="nav-item">
              <a class="nav-link" href="notifications.php">
                  <span class="notification-icon">
                      <i class='bx bxs-bell'><span id="notif-number"></span></i>
                      <span class="notification-text  ">Notifications</span>
                  </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.html">Logout</a>
            </li>
          </ul>
        </div>
    </nav>
    <h1 class="heading">Our Users</h1>

    <table id="userTable">
        <thead>
            <tr>
                <!-- <th>Edit</th> -->
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email Address</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="add-users">
            <h3>Onboard Users</h3>
            <form method="post" action="users.php">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">User's Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                </div>
                <button type="submit" class="btn btn-primary" name="button">Add User</button>
            </form>
    </div>


<script src="./js/users.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<?php 
include "config.php";

if (isset($_POST["button"])) {
    // Validate the email input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/JavaScript">'; 
        echo 'alert("Invalid email address!")';
        echo '</script>';  
    } else {
        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO users (Firstname, Lastname, Email, Password, is_admin, isCFO, first_login) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        
        $firstName = '';
        $lastName = '';
        $password = '';
        $id_admin = 0;
        $isCFO = 0;
        $firstLogin = 1;

        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssiii", $firstName, $lastName, $email, $password, $id_admin, $isCFO, $firstLogin);

        if ($stmt->execute()) {
            echo '<script type="text/JavaScript">'; 
            echo 'alert("User successfully onboarded!")';
            echo '</script>';  
        } else {
            echo '<script type="text/JavaScript">'; 
            echo 'alert("Error onboarding user: ' . $stmt->error . '")';
            echo '</script>';  
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}

?>
