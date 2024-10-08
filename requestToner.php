<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toners</title>
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
        .sub-heading{
            text-align: center;
            
        }
        #tonerTable {
            margin: 50px auto 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
            color: black;
        }

        #tonerTable td, #tonerTable th {
            border: 1px solid #ddd;
            padding: 8px;
        }
 
        #tonerTable tr{
            background-color: white;
        }
        #tonerTable tr:hover {
            background-color: #ddd;
        }

        #tonerTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: dodgerblue;
            color: white;
        }
        #tonerTable a{
            color: black;
            text-decoration: none;
            text-transform: capitalize;

        }
        #tonerTable i{
            color: red;
            cursor: pointer;
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
            <li class="nav-item active">
              <a class="nav-link" href="requestToner.php">Request Toner</a>
            </li>
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
    <h1 class="heading">The Toner Inventory Table</h1>

    <p class="sub-heading">Click on desired Row to make a request</p>
    <table id="tonerTable">
        <thead>
            <tr>
                <th>Toner Name</th>
                <th>Quantity available</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <!-- Toner Request Modal -->
    <div class="modal fade" id="tonerRequestModal" tabindex="-1" role="dialog" aria-labelledby="tonerRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="tonerRequestModalLabel">Request Toner</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form id="tonerRequestForm" action="tonerRequest.php" method="POST">
                <div class="form-group">
                <label for="tonerName">Toner Name</label>
                <input type="text" class="form-control" id="tonerName" name="tonerName" readonly>
                </div>
                <div class="form-group">
                <label for="requestQuantity">Quantity</label>
                <input type="number" class="form-control" id="requestQuantity" name="requestQuantity" min="1" required>
                </div>
                <input type="hidden" id="tonerId" name="tonerId">
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submitRequest">Request Toner</button>
            </div>
        </div>
        </div>
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

<script src="./js/requestToner.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>