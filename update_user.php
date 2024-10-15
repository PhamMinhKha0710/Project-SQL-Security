<?php
session_start();
include 'db_connection.php';

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'];
    $value = $_POST['value'];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session after login

    // Sanitize input
    $field = mysqli_real_escape_string($conn, $field);
    $value = mysqli_real_escape_string($conn, $value);

    // Update the user information in the database
    $query = "UPDATE users SET $field = ? WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $value, $user_id);
        $stmt->execute();

        // Check if any row was updated
        if ($stmt->affected_rows > 0) {
            echo "User information updated successfully.";
        } else {
            echo "No changes were made.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
