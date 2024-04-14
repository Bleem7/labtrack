<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>





<?php
header('Content-Type: application/json');

include_once '../settings/connection.php';

$sql = "SELECT * FROM reminders";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$reminders = array();

while ($row = $result->fetch_assoc()) {
    $reminders[] = [
        'title' => $row['taskname'] . ' ' . $row['reminder_time'],
        'start' => $row['reminder_date'],
    ];
}

$stmt->close();

echo json_encode($reminders);