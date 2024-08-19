<?php 
    include "config.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tonerId = $_POST['tonerId'];
        $tonerName = $_POST['tonerName'];
        $requestQuantity = $_POST['requestQuantity'];
    
        $sql = "INSERT INTO toner_requests (Toner_id, TonerName, RequestQuantity) VALUES ('$tonerId', '$tonerName', '$requestQuantity')";
        
        if (mysqli_query($conn, $sql)) {
            $response = array('message' => 'Toner request successfully submitted!');
        } else {
            $response = array('message' => 'Failed to submit toner request.');
        }
    
        echo json_encode($response);
    }
    
    mysqli_close($conn);

?>