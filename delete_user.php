<?php
include "config.php";

if (isset($_GET["name"]) && isset($_GET["row"])) {
    $rowName = $_GET["name"];
    $rowId = $_GET["row"]; 

    // Delete the row from the users table
    $deleteQuery = "DELETE FROM users WHERE Firstname = '$rowName' AND User_id = '$rowId'";
    
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: users.html");
        exit();
    } else {
        echo "Error deleting row: " . $conn->error;
    }

    $conn->close();
}
?>
