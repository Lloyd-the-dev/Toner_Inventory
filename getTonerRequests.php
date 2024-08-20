<?php 
    include "config.php";
    $sql = "SELECT * FROM toner_requests WHERE RequestStatus = 'Pending'";

    $result = $conn->query($sql);

    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    
    echo json_encode($data);
    mysqli_close($conn);
?>