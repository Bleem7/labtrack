<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>




<?php
// Include the connections.php file to establish the database connection
include '../settings/connection.php';

// Get the JSON data from the request body
$json = file_get_contents('php://input');

// Decode the JSON data to an associative array
$data = json_decode($json, true);

$response = array();

if (isset($data['task_id'])) {
    // Retrieve data from the decoded JSON data
    $taskId = $data['task_id'];

    // Prepare and execute SQL statement to delete the task
    $sql = "DELETE FROM Tasks WHERE TaskID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Task deleted successfully';
    } else {
        // Error deleting task
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

// Close database connection
$conn->close();

// Return the response as JSON
echo json_encode($response);
?>
