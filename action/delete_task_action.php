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

$data = json_decode($json, true);

$response = array();

if (isset($data['task_id'])) {
    $taskId = $data['task_id'];

    $sql = "DELETE FROM Tasks WHERE TaskID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Task completed successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . ' - ' . $conn->error;
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: Insufficient data received';
}

echo json_encode($response);
