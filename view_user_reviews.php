<?php

$page_title = "CineCritique: User Reviews";

require_once('includes/header.php');
require_once('includes/database.php');

// Check if the user is an admin or the logged-in user (You may need to adjust the role based on your database structure)
if ($_SESSION['role'] != 1 && $_SESSION['user_id'] != $_GET['user_id']) {
    // Redirect to a page with appropriate access denial message
    header("Location: access_denied.php");
    exit();
}

// Get user information
$user_id = $_GET['user_id'];
$user_query = "SELECT * FROM users WHERE user_id = '$user_id'";
$user_result = $conn->query($user_query);
$user_row = $user_result->fetch_assoc();

// Get user reviews
$review_query = "SELECT * FROM reviews WHERE review_user_id = '$user_id'";
$review_result = $conn->query($review_query);
?>

<div class="container wrapper">
    <h1 class="text-center"><?= $user_row['user_name'] ?>'s Reviews</h1>

    <?php if ($review_result->num_rows > 0) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Rating</th>
                    <th>Review Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review_row = $review_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= getMovieName($conn, $review_row['review_movie_id']) ?></td>
                        <td><?= $review_row['review_rating'] ?></td>
                        <td><?= $review_row['review_content'] ?></td>
                        <td>
                            <!-- Add a form to handle the deletion of the review -->
                            <form method="post" action="delete_review.php">
                                <input type="hidden" name="review_id" value="<?= $review_row['review_id'] ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="text-center">No reviews found for this user.</p>
    <?php endif; ?>
</div>

<?php
$conn->close();
include('includes/footer.php');

// Function to get movie name based on movie_id
function getMovieName($conn, $movie_id)
{
    $movie_query = "SELECT movie_name FROM movies WHERE movie_id = '$movie_id'";
    $movie_result = $conn->query($movie_query);
    $movie_row = $movie_result->fetch_assoc();
    return ($movie_row) ? $movie_row['movie_name'] : 'Unknown';
}
?>
