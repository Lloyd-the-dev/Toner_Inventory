<?php 
include "config.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
    if($count == 1){
        session_start();
        $_SESSION["user_id"] = $row["User_id"];
        $_SESSION["name"] = $row["Firstname"];
        $_SESSION["mail"] = $row["Email"];
        $_SESSION["isAdmin"] = $row["is_admin"];
        $_SESSION["isCFO"] = $row["isCFO"];
        $_SESSION["firstLogin"] = $row["first_login"];
        header("Location: dashboard.php");
        
    }  
    else{  
        echo '<script type="text/JavaScript">';
        echo 'alert("Invalid credentials, Contact an admin");';
        echo 'window.location.href = "login.html";'; // Redirect after displaying the alert
        echo '</script>';
    }     

    $conn->close();
?>