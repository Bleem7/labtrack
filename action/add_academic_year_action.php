<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>





<?php
include '../settings/connection.php';

// Get form data
$start_date = $_POST['start_date'];
$scheduling_terms = $_POST['scheduling_terms'];
$end_date = $_POST['end_date'];

// Prepare and execute SQL statement to insert the new academic year
$stmt = $conn->prepare("INSERT INTO Academic_year (name, start_date, end_date, scheduling_terms) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $academic_year_name, $start_date, $end_date, $scheduling_terms);

$academic_year_name = "Academic Year"; // You can modify this as needed

if ($stmt->execute()) {
    $last_id = $conn->insert_id;

    // Fetch the newly inserted academic year from the database
    $sql = "SELECT * FROM Academic_year WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $last_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Return the response as JSON
    echo json_encode(['status' => 'success', 'data' => $row, 'message' => 'Academic year added successfully']);
} else {
    // Error adding academic year
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $sql . ' - ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
