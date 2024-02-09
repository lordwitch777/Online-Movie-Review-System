<?php
session_start();

require_once 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['movie_name']) ? $_POST['movie_name'] : '';
    $year = isset($_POST['movie_year']) ? $_POST['movie_year'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';

    // Extract selected genres
    $selectedGenres = isset($_POST['genres']) ? $_POST['genres'] : [];

    // Insert movie details into the movies table using prepared statements
    $insertMovieQuery = $conn->prepare("INSERT INTO movies (movie_name, movie_year, movie_bio, movie_rating, movie_img, genre_name) 
                                       VALUES (?, ?, ?, ?, ?, ?)");
    $insertMovieQuery->bind_param("ssssss", $title, $year, $bio, $rating, $image, implode(',', $selectedGenres));
    
    // Execute the prepared statement
    $result = $insertMovieQuery->execute();

    // Handle error
    if (!$result) {
        $errno = $insertMovieQuery->errno;
        $errmsg = $insertMovieQuery->error;
        echo "Insertion failed with: ($errno) $errmsg<br/>\n";
        $insertMovieQuery->close();
        $conn->close();
        exit;
    }

    // Get the ID of the last inserted movie
    $lastMovieId = $insertMovieQuery->insert_id;

    // Insert movie-genre relationships into the movie_genres table
    foreach ($selectedGenres as $genreId) {
        $insertGenreQuery = "INSERT INTO movie_genres (movie_id, genre_id) 
                             VALUES ($lastMovieId, $genreId)";
        $result = @$conn->query($insertGenreQuery);

        // Handle error
        if (!$result) {
            $errno = $conn->errno;
            $errmsg = $conn->error;
            echo "Genre insertion failed with: ($errno) $errmsg<br/>\n";
            $insertMovieQuery->close();
            $conn->close();
            exit;
        }
    }

    // Close the prepared statement
    $insertMovieQuery->close();

    header("Location: movies.php");
    exit();
} else {
    // Handle invalid requests
    header("Location: index.php");
    exit();
}
?>
