<?php
// Disable caching
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

// Database connection
include '../settings/connection.php';

// Query to select reminders within 10 seconds range of current time

// SQL query to retrieve all data from the reminders table
$sql = "SELECT * FROM reminders";

$result = $conn->query($sql);

$rows = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($rows);

?>