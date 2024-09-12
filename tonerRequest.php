<?php 
include "config.php";
session_start();
$userId = $_SESSION["user_id"];
$userEmail = $_SESSION["mail"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tonerId = $_POST['tonerId'];
    $tonerName = $_POST['tonerName'];
    $requestQuantity = $_POST['requestQuantity'];
    
    // Check the available quantity in the toner_inventory table
    $checkStock = "SELECT TonerQuantity FROM toner_inventory WHERE Toner_id = '$tonerId'";
    $stockResult = mysqli_query($conn, $checkStock);
    
    if ($stockResult->num_rows > 0) {
        $row = $stockResult->fetch_assoc();
        $availableQuantity = $row['TonerQuantity'];

        if ($requestQuantity > $availableQuantity) {
            // If requested quantity is greater than available stock, return an error
            $response = array('message' => 'Not enough toner in stock. Available quantity: ' . $availableQuantity);
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array('message' => 'Toner not found.');
        echo json_encode($response);
        exit();
    }

    // Insert the toner request into the database
    $sql = "INSERT INTO toner_requests (Toner_id, TonerName, RequestQuantity, userId, userEmail) 
            VALUES ('$tonerId', '$tonerName', '$requestQuantity', '$userId', '$userEmail')";
    
    if (mysqli_query($conn, $sql)) {
        $date = date("Y-m-d"); 
        // Notify all CFOs
        $notificationContent = "A new toner request has been submitted for $tonerName By $userEmail on $date.";
        
        // Query to get all CFOs
        $getCFOs = "SELECT User_id FROM users WHERE isCFO = 1";
        $result = mysqli_query($conn, $getCFOs);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cfoId = $row['User_id'];
                $notifyCFO = "INSERT INTO notifications (user_notified, notification_content, is_cleared) 
                              VALUES ('$cfoId', '$notificationContent', 0)";
                mysqli_query($conn, $notifyCFO); // Insert notification for each CFO
            }
        }

        $response = array('message' => 'Toner request successfully submitted!');
    } else {
        $response = array('message' => 'Failed to submit toner request.');
    }

    echo json_encode($response);
}

mysqli_close($conn);
?>
