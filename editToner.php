<?php 
    include "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tonerId = $_POST['tonerId'];
        $tonerName = $_POST['tonerName'];
        $tonerQuantity = $_POST['tonerQuantity'];
    
        $sql = "UPDATE toner_inventory SET TonerName = '$tonerName', TonerQuantity = '$tonerQuantity' WHERE Toner_id = $tonerId";
    
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Toner updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating toner: ' . $conn->error]);
        }
    
        mysqli_close($conn);
    }
?>