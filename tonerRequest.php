<?php 
include "config.php";
session_start();
$userId = $_SESSION["user_id"];
$userEmail = $_SESSION["mail"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tonerId = $_POST['tonerId'];
    $tonerName = $_POST['tonerName'];
    $requestQuantity = $_POST['requestQuantity'];
    
    // Insert the toner request into the database
    $sql = "INSERT INTO toner_requests (Toner_id, TonerName, RequestQuantity, userId, userEmail) VALUES ('$tonerId', '$tonerName', '$requestQuantity', '$userId', '$userEmail')";
    
    if (mysqli_query($conn, $sql)) {
        // Notify all CFOs
        $notificationContent = "A new toner request has been submitted for $tonerName.";
        
        // Query to get all CFOs
        $getCFOs = "SELECT User_id FROM users WHERE isCFO = 1";
        $result = mysqli_query($conn, $getCFOs);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cfoId = $row['User_id'];
                $notifyCFO = "INSERT INTO notifications (user_notified, notification_content, is_cleared) VALUES ('$cfoId', '$notificationContent', 0)";
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
