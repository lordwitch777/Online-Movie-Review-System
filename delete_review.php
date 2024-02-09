<?php

require_once('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the review_id is set in the POST data
    if (isset($_POST['review_id'])) {
        // Sanitize the input
        $review_id = $_POST['review_id'];

        // Get the user_id before deletion to redirect back to the correct user's reviews
        $user_id_query = "SELECT review_user_id FROM reviews WHERE review_id = '$review_id'";
        $user_id_result = $conn->query($user_id_query);
        $user_id_row = $user_id_result->fetch_assoc();
        $user_id = $user_id_row['review_user_id'];

        // Perform the deletion
        $delete_query = "DELETE FROM reviews WHERE review_id = '$review_id'";
        $result = $conn->query($delete_query);

        if ($result) {
            // Successful deletion
            header("Location: user_list.php?user_id=$user_id");
            exit();
        } else {
            // Error handling (you may want to improve this)
            echo "Error deleting the review: " . $conn->error;
        }
    } else {
        // If review_id is not set in the POST data, redirect to an error page or handle accordingly
        header("Location: error.php");
        exit();
    }
} else {
    // If the request method is not POST, redirect to an error page or handle accordingly
    header("Location: error.php");
    exit();
}

$conn->close();
?>
