<?php
// Start the session
@session_start();

$page_title = "CineCritique: User Reviews";
include_once('includes/header.php');
require_once('includes/database.php');

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // If not logged in, redirect to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Fetch the user's reviews from the database, joining with movies to get movie names
$query_str = "SELECT r.*, m.movie_name, m.movie_id FROM reviews r JOIN movies m ON r.review_movie_id = m.movie_id WHERE r.review_user_id = $user_id";
$result = $conn->query($query_str);

// Check if there are reviews
if ($result && $result->num_rows > 0) {
    // Display the reviews
    echo '<div class="container wrapper">';
    echo '<h1 class="text-center">' . $_SESSION['name'] . "'s Reviews</h1>";

    while ($row = $result->fetch_assoc()) {
        // Display user's review content with movie name and link to the movie
        echo '<div>';
        echo '<h2>Review for Movie: <a href="moviedetails.php?id=' . $row['movie_id'] . '">' . $row['movie_name'] . '</a></h2>';
        echo '<p>Rating: ' . $row['review_rating'] . '</p>';
        echo '<p>Review: ' . $row['review_content'] . '</p>';
        echo '</div>';
    }

   

    echo '</div>';
} else {
    // If no reviews found
    echo '<div class="container wrapper">';
    echo '<h1 class="text-center">' . $_SESSION['name'] . "'s Reviews</h1>";
    echo '<p>No reviews found.</p>';
    echo '</div>';
}

$conn->close();
include_once('includes/footer.php');
?>
