<?php
include "config.php";

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];

    // Fetch the user who made the request
    $sql = "SELECT userId, TonerName FROM toner_requests WHERE Request_id = $requestId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();
        $tonerName = $request['TonerName'];
        $userId = $request['userId']; // Get the user_id who made the request

        // Update the request status to 'Rejected'
        $updateRequestStatus = "UPDATE toner_requests SET RequestStatus = 'Rejected' WHERE Request_id = $requestId";

        if ($conn->query($updateRequestStatus) === TRUE) {
            // Insert notification for rejected request
            $notificationContent = "Your request for $tonerName toner has been rejected.";
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
        echo json_encode(['success' => false, 'message' => 'Request not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No request ID provided']);
}

mysqli_close($conn);
?>
