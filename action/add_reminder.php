<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>





<?php
// Include the connection file
include '../settings/connection.php';

// Get the JSON data from the request body
$json = file_get_contents('php://input');

// Decode the JSON data to an associative array
$data = json_decode($json, true);

$response = array();

if (isset($data['task']) && isset($data['date']) && isset($data['time'])) {
    // Retrieve data from the decoded JSON data
    $task = $data['task'];
    $date = $data['date'];
    $time = $data['time'];

    // Prepare and execute SQL statement to insert the new reminder
    $sql = "INSERT INTO reminders (taskname, reminder_date, reminder_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $task, $date, $time);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Reminder added successfully';
    } else {
        // Error adding reminder
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . ' - ' . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Insufficient data received
    $response['status'] = 'error';
    $response['message'] = 'Error: Insufficient data received';
}

// Return the response as JSON
echo json_encode($response);

// Close database connection
$conn->close();
?>
