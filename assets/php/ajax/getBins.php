<?php
require_once('../mysql.php');

$sql = "SELECT * FROM bins";
$result = $conn->query($sql);
$rows = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

$conn->close();

echo json_encode($rows);
?>
