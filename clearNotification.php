<?php 
    include "config.php";

    if(isset($_GET["id"])){
        $notificationId = $_GET["id"];

        $sql = "UPDATE notifications SET is_cleared = 1 WHERE notification_id = $notificationId";

        if($conn->query($sql)){
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        mysqli_close($conn);
    }
?>