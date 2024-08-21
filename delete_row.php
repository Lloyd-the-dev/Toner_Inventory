<?php
include "config.php";

if (isset($_GET["name"]) && isset($_GET["row"])) {
    $rowName = $_GET["name"];
    $rowId = $_GET["row"]; 

    // Delete the row from the toner_inventory table
    $deleteQuery = "DELETE FROM toner_inventory WHERE TonerName = '$rowName' AND Toner_id = '$rowId'";
    
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: toner.php");
        exit();
    } else {
        echo "Error deleting row: " . $conn->error;
    }

    $conn->close();
}
?>
