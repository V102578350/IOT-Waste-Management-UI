<?php
// Database credentials
$servername = "db-mysql-syd1-93145-do-user-3086589-0.b.db.ondigitalocean.com";
$username = "doadmin";
$password = "AVNS_NzPPuN9wnQ6ImJafnnC";
$dbname = "defaultdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 25060);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
