<?php
// Define parameters
$host = "localhost";
$port;
$login = "root";
$password = "";
$database = "jayrolex";
$tblMovies = "movies";
$tblUsers = "users";
$tblReviews = "reviews";
$tblGenres = "genres"; // Add this line for genres table

// Connect to the MySQL server
$conn = @new mysqli($host, $login, $password, $database, $port);

// Handle connection errors
if (mysqli_connect_errno() != 0) {
    $errno = mysqli_connect_errno();
    $errmsg = mysqli_connect_error();
    die("Connect Failed with: ($errno) $errmsg<br/>\n");
}

// Function to get genres
function getGenres() {
    global $conn, $tblGenres;
    $genreQuery = "SELECT * FROM $tblGenres";
    $result = $conn->query($genreQuery);
    $genres = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }
    }

    return $genres;
}
?>
