<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>





<?php
include '../settings/connection.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM Tasks WHERE TaskDueDate >= CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$tasks = array();

while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'title' => $row['task_name'],
        'start' => $row['TaskDueDate'],
    ];
}

$stmt->close();

echo json_encode($tasks);
?>