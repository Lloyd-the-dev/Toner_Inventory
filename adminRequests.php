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
    <title>Admin - Toner Requests</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .card {
            margin-bottom: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: dodgerblue;
            color: white;
        }
        .btn-approve {
            background-color: green;
            color: white;
        }
        .btn-reject {
            background-color: red;
            color: white;
        }
        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            <li class="nav-item">
              <a class="nav-link" href="users.php">Users</a>
            </li>
            <?php } ?>
            <?php if($isAdmin || $isCFO) { ?>
            <li class="nav-item active">
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
    <div class="container">
        <h1 class="mt-5 mb-4 text-center">Toner Requests</h1>

        <div id="requestsContainer"></div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7HUIbX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./js/admin.js"></script>
</body>
</html>
