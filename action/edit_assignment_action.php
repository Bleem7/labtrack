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

if (isset($data['task_id']) && isset($data['task_name']) && isset($data['task_due_date'])) {
    // Retrieve data from the decoded JSON data
    $taskId = $data['task_id'];
    $taskName = $data['task_name'];
    $taskDueDate = $data['task_due_date'];

    // Prepare and execute SQL statement to update the task
    $sql = "UPDATE Tasks SET task_name = ?, TaskDueDate = ? WHERE TaskID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $taskName, $taskDueDate, $taskId);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Task updated successfully';
    } else {
        // Error updating task
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
