<?php

$page_title = "CineCritique: User List";

require_once('includes/header.php');
require_once('includes/database.php');

// Check if the user is an admin (You may need to adjust the role based on your database structure)
if ($_SESSION['role'] != 1) {
    // Redirect to a page with appropriate access denial message
    header("Location: access_denied.php");
    exit();
}

// Check if a user_id parameter is provided for banning
if (isset($_GET['ban_user_id'])) {
    $ban_user_id = $_GET['ban_user_id'];

    // Delete user account
    $delete_user_query = "DELETE FROM users WHERE user_id = '$ban_user_id'";
    $delete_user_result = $conn->query($delete_user_query);

    // Check if the user account was successfully deleted
    if ($delete_user_result) {
        // Redirect back to the user list page with a success message
        header("Location: user_list.php?success=1");
        exit();
    } else {
        // Redirect back to the user list page with an error message
        header("Location: user_list.php?error=1&message=" . $conn->error);
        exit();
    }
}

// Retrieve user list
$query_str = "SELECT * FROM users";
$result = $conn->query($query_str);
?>

<div class="container wrapper">
    <h1 class="text-center">User List</h1>

    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user_row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $user_row['user_id'] ?></td>
                    <td><?= $user_row['user_name'] ?></td>
                    <td><?= $user_row['user_full_name'] ?></td>
                    <td><?= $user_row['user_email'] ?></td>
                    <td><?= ($user_row['user_role'] == 1) ? 'Admin' : 'User' ?></td>
                    <td>
                        <a href="view_user_reviews.php?user_id=<?= $user_row['user_id'] ?>">View Reviews</a>
                        |
                        <a href="user_list.php?ban_user_id=<?= $user_row['user_id'] ?>" onclick="return confirm('Are you sure you want to ban this user?')">Ban User</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
include('includes/footer.php');
?>
