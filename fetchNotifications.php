<?php 

    include "config.php";
    session_start();
    $userId = $_SESSION["user_id"];

    $sql = "SELECT * FROM notifications WHERE user_notified = $userId AND is_cleared=0";

    $result = $conn->query($sql);

    $notifications = [];
    while($row = $result->fetch_assoc()){
        $notifications[] = $row;
    }
    
    echo json_encode(['notifications' => $notifications]);
    mysqli_close($conn);
?>