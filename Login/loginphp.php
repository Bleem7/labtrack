<?php
session_start(); // Start the session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../settings/connection.php';

// Function to check if a string contains only alphabetic characters
function isAlphabetic($str) {
    return preg_match("/^[a-zA-Z]+$/", $str);
}

$username = trim($_POST['username']);
$password = $_POST['password'];
$_SESSION['email'] = $row['Email'];

// Check if username contains only alphabetic characters
if (!isAlphabetic($username)) {
    // Echo the Sweet Alert script and exit
    echo <<<HTML
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username must contain only alphabetic characters!',
                onClose: () => {
                    window.location.href = '../view/loginpage.html';
                }
            });
        </script>
    HTML;
    exit(); // Stop further execution
}

$stmt = $conn->prepare("SELECT UserID, Password FROM Users WHERE Username = ?");
$stmt->bind_param("s", $username);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['Password'];

    if (password_verify($password, $hashed_password)) {
        $_SESSION['UserID'] = $row['UserID'];
        $_SESSION['Username'] = $username;

        // Redirect to dashboard or any other authenticated page
        header("Location: ../view/dashboard.php");
        exit();
    } else {
        // Password is incorrect
        echo "Incorrect password!";
    }
} else {
    // User does not exist
    echo "User not found!";
}

$stmt->close();
?>
