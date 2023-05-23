<?php
require_once('../mysql.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $binId = $_POST['binId'];
    $command = $_POST['command'];

    $sql = "INSERT INTO binUpdateRequest (binId, command) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $binId, $command);
    
    if ($stmt->execute()) {
        $response['status'] = true;
        $response['message'] = "Bin update request inserted successfully.";
    } else {
        $response['status'] = false;
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
