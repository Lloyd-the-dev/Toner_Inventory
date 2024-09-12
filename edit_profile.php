<?php
include "config.php"; 

session_start();
$employeeId = $_SESSION["user_id"];
$firstLogin = $_SESSION["firstLogin"];
$isAdmin = $_SESSION["isAdmin"];
$isCFO = $_SESSION["isCFO"];
$firstLogin = $_SESSION["firstLogin"];

if($firstLogin == 1){
    echo '<script type ="text/JavaScript">'; 
    echo 'alert("On first Login you should select a strong password and update your profile")';
    echo '</script>';

     // Reset firstLogin to 0 so the message doesn't appear again
     $_SESSION["firstLogin"] = 0;

     // Update the database to reflect that the user is no longer on their first login
     $updateLoginStatus = "UPDATE users SET first_login = '0' WHERE User_id = '$employeeId'";
     if ($conn->query($updateLoginStatus) !== TRUE) {
         echo "Error updating login status: " . $conn->error;
     }
}

$sql = "SELECT * FROM users WHERE User_id = '$employeeId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employeeFirstname = $row['Firstname'];
    $employeeLastname = $row['Lastname'];
    $employeeFullname = $row['Firstname']. " " . $row['Lastname'];
    $employeeEmail = $row['Email'];
    $employeePassword = $row["Password"];

} else {
    echo "Employee not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $employeeFullname; ?>'s Profile</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <li class="nav-item active">
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


    <div class="container rounded bg-white mt-5">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" src="./images/user-profile.webp" width="90"><span class="font-weight-bold"><?php echo $employeeFirstname; ?></span><span class="text-black-50"><?php echo $employeeEmail; ?></span></div>
            </div>
            <div class="col-md-8">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-right">Edit Profile</h6>
                    </div>
                    <form action="edit_profile.php" method="POST">
                        <div class="row mt-2">
                                <div class="col-md-6"><input type="text" class="form-control" placeholder="first name" value="<?php echo $employeeFirstname; ?>" name="first_name"></div>
                                <div class="col-md-6"><input type="text" class="form-control" value="<?php echo $employeeLastname; ?>" placeholder="Lastname" name="last_name"></div>
                        </div>
                        <div class="row mt-3">
                                <div class="col-md-6"><input type="text" class="form-control" placeholder="Email" value="<?php echo $employeeEmail; ?>" name="email"></div>
                        </div>
                        <div class="row mt-3">
                                <div class="col-md-6"><input type="password" id="passwordField" class="form-control" value="<?php echo $employeePassword; ?>" placeholder="Password" name="Password"><button id="togglePassword" type="button" style="cursor: pointer;">Show</button></div>
                        </div>
                        </div>
                        <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit" name="submit">Save Profile</button></div>
                        </div>
                    </form>
                    
            </div>
    </div>
    <!-- </div> -->
    <script>
        const passwordField = document.getElementById('passwordField');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePassword.textContent = 'Hide';
        } else {
            passwordField.type = 'password';
            togglePassword.textContent = 'Show';
        }
        });

    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
<?php 
    include "config.php";
    // session_start();


    // Get the employee ID from the query parameter
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newFirstname = $_POST["first_name"];
        $newLastname = $_POST["last_name"];
        $newEmail = $_POST["email"];
        $newPassword = $_POST["Password"];
        $userId = $_SESSION["user_id"];

        $updateQuery = "UPDATE users SET Firstname = '$newFirstname', Lastname = '$newLastname', Email = '$newEmail', Password = '$newPassword', first_login = '0' WHERE User_id = '$userId'";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo '<script type ="text/JavaScript">'; 
            echo 'alert("Profile Updated successfully!")';
            echo 'window.location.reload()';
            echo '</script>';
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    
        $conn->close();
    }
?>
