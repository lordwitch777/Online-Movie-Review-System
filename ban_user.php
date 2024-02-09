<?php

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    // Redirect to a page with appropriate access denial message
    header("Location: access_denied.php");
    exit();
}

require_once('includes/database.php');

// Get the user_id from the URL parameter
$user_id = $_GET['user_id'];

// Delete user account
$delete_user_query = "DELETE FROM users WHERE user_id = '$user_id'";
$delete_user_result = $conn->query($delete_user_query);

// Check if the user account was successfully deleted
if ($delete_user_result) {
    // Redirect back to the user list page with a success message
    header("Location: user_list.php?success=1");
} else {
    // Redirect back to the user list page with an error message
    header("Location: user_list.php?error=1&message=" . $conn->error);
}

$conn->close();
?>
