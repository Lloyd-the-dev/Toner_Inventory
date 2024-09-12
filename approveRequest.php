<?php
include "config.php";

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];

    // Fetch the requested toner details and user who made the request
    $sql = "SELECT Toner_id, RequestQuantity, userId, TonerName FROM toner_requests WHERE Request_id = $requestId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();
        $tonerId = $request['Toner_id'];
        $requestedQty = $request['RequestQuantity'];
        $tonerName = $request['TonerName'];
        $userId = $request['userId']; // Get the userId who made the request

        // Update the toner inventory: reduce the quantity by the requested amount
        $updateInventory = "UPDATE toner_inventory SET TonerQuantity = TonerQuantity - $requestedQty WHERE Toner_id = $tonerId";

        if ($conn->query($updateInventory) === TRUE) {
            // If the inventory update is successful, update the request status to 'Approved'
            $updateRequestStatus = "UPDATE toner_requests SET RequestStatus = 'Approved' WHERE Request_id = $requestId";

            if ($conn->query($updateRequestStatus) === TRUE) {
                // Insert notification for approved request
                $notificationContent = "Your request for $tonerName toner has been approved.";
                $insertNotification = "INSERT INTO notifications (notification_content, user_notified, is_cleared) VALUES ('$notificationContent', $userId, 0)";

                if ($conn->query($insertNotification) === TRUE) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to insert notification']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update toner inventory']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Request not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No request ID provided']);
}

mysqli_close($conn);
?>
