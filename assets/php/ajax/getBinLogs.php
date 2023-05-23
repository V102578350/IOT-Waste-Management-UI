<?php
require_once('../mysql.php');

// Select all rows from binLogs table
$sql = "SELECT * FROM binLogs";
$result = $conn->query($sql);

if ($result) {
    // Array to store the retrieved bin logs
    $binLogs = array();

    while ($row = $result->fetch_assoc()) {
        // Add each row to the binLogs array
        $binLogs[] = $row;
    }

    // Return the bin logs as JSON response
    header('Content-Type: application/json');
    echo json_encode($binLogs);
} else {
    // Error retrieving bin logs
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
