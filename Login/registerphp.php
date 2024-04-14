<?php
include_once '../settings/connection.php';

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if the username already exists
    $stmt_check_username = $conn->prepare("SELECT UserID FROM Users WHERE Username = ?");
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    if($result_check_username->num_rows > 0) {
        echo "Username already exists!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt_insert_user = $conn->prepare("INSERT INTO Users (Username, Password, Email) VALUES (?, ?, ?)");
    $stmt_insert_user->bind_param("sss", $username, $hashed_password, $email);

    if($stmt_insert_user->execute()) {
        echo "User registered successfully!";
        // Redirect the user to the login page
        header("Location: ../view/loginpage.html"); // Adjust the path as needed
        exit();
    } else {
        echo "Error registering user!";
    }

    // Close statements
    $stmt_check_username->close();
    $stmt_insert_user->close();
} else {
    echo "Username or password not provided!";
}

$conn->close();
?>
