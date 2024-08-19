<?php
include "config.php";
session_start();
$userId = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE User_id = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['Firstname'];
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <!-- Navbar content -->
    <a class="navbar-brand" href="#">TonerLOG</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link mr-8" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="toner.html">toners</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.html">Logout</a>
      </li>
    </ul>
  </div>
</nav>

    <div class="welcome_heading">
        <h2>Welcome, <?php echo $name; ?></h2>
    </div>

    
    <h2 class="form_heading">Add new Item</h2>
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