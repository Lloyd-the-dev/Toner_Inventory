<?php 
    include "config.php";

    if(isset($_GET["requestId"])){
        $requestId = $_GET["requestId"];

        $sql = "UPDATE toner_requests SET RequestStatus = 'Rejected' WHERE Request_id = $requestId";

        if(mysqli_query($conn, $sql)){
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }


    mysqli_close($conn);
?>