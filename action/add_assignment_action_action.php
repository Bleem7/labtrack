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

if (isset($data['taskName']) && isset($data['taskDueDate'])) {
    // Retrieve data from the decoded JSON data
    $taskName = $data['taskName'];
    $taskDueDate = $data['taskDueDate'];

    // Prepare and execute SQL statement to insert the new assignment
    $sql = "INSERT INTO Tasks (task_name, TaskDueDate) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $taskName, $taskDueDate);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        $sql = "SELECT * FROM Tasks WHERE TaskID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $last_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $response['status'] = 'success';
        $response['data'] = $row;
        $response['message'] = 'Assignment added successfully';
    } else {
        // Error adding assignment
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