<?php
include "config.php";
session_start();
$userId = $_SESSION["user_id"];
$isAdmin = $_SESSION["isAdmin"];
$isCFO = $_SESSION["isCFO"];
$firstLogin = $_SESSION["firstLogin"];

if($firstLogin == 1){
   header("Location: edit_profile.php");
} else {
  $sql = "SELECT * FROM users WHERE User_id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Firstname'];
        
    }
    $countQuery = "SELECT COUNT(*) as notif_count FROM notifications WHERE user_notified = '$userId' AND is_cleared = 0";
    $result = $conn->query($countQuery);

    $notif_count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $notif_count = $row['notif_count'];
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/style.css">
   
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
      <li class="nav-item active">
        <a class="nav-link mr-8" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="toner.php">toners</a>
      </li>
      <?php 
          if($isAdmin){
      ?>
      <li class="nav-item">
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
    <div class="welcome_heading">
        <h2>Welcome, <?php echo $name; ?>
        <?php if($isAdmin) {
          echo "(ADMIN)";
        } else if($isCFO){
          echo "(CFO)"?>
        <?php 
        } ?> </h2>
    </div>

    
    <?php 
        if($isAdmin){
    ?>
          <h2 class="form_heading">Add new Toner</h2>
          <form action="dashboard.php" method="POST" class="dashboard_form">
              <div class="form-group">
                  <label>Toner name</label>
                  <input type="text" class="form-control text-uppercase" name="tonerName">
              </div>
              <div class="form-group">
                  <label>Total available number</label>
                  <input type="number" class="form-control" name="tonerQuantity">
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </form>
      
    <?php } ?>
    
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          // Get the notification count from PHP
          var notifCount = <?php echo $notif_count; ?>;

          // Display the count in the span with id 'notif-number'
          if(notifCount > 0) {
              document.getElementById("notif-number").textContent = notifCount;
              document.getElementById("notif-number").style.backgroundColor = "red";
              document.getElementById("notif-number").style.color = "white";
              document.getElementById("notif-number").style.borderRadius = "50%";
              document.getElementById("notif-number").style.padding = ".1rem .3rem";
              document.getElementById("notif-number").style.position = "absolute";
              document.getElementById("notif-number").style.top = ".7rem";
              document.getElementById("notif-number").style.right = "5rem";
              document.getElementById("notif-number").style.fontSize = ".7rem";
          }
      });
    </script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["tonerName"]) && !empty($_POST["tonerQuantity"])){
        $tName = $_POST["tonerName"];
        $tQty = $_POST["tonerQuantity"];

        $sql = "INSERT INTO `toner_inventory` (`Toner_id`, `TonerName`, `TonerQuantity`) VALUES ('0', '$tName', '$tQty')";

        $result = mysqli_query($conn, $sql);

        if($result)
        {
            echo '<script type ="text/JavaScript">'; 
            echo 'alert("Toner successfully added!")';
            echo '</script>';
        }
    } else {
        echo '<script type ="text/JavaScript">'; 
        echo 'alert("Both fields have to be filled")';
        echo '</script>';
  }
}

    
    mysqli_close($conn);    
?>