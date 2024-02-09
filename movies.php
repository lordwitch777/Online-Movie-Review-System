<?php

$page_title = "CineCritiq: Movies";

require_once('includes/header.php');
require_once('includes/database.php');

// Select all genres for the dropdown list
$queryGenres = "SELECT * FROM genres";
$resultGenres = $conn->query($queryGenres);

// Select statement for movies
$queryMovies = "SELECT * FROM movies";

// Check if a specific genre is selected
if (isset($_GET['genre_id'])) {
    $genreId = $_GET['genre_id'];

    // Filter movies by genre
    $queryMovies .= " INNER JOIN movie_genres ON movies.movie_id = movie_genres.movie_id";
    $queryMovies .= " WHERE movie_genres.genre_id = $genreId";
}

// Execute the movie query
$resultMovies = $conn->query($queryMovies);

// Handle selection errors
if (!$resultGenres || !$resultMovies) {
    $errno = $conn->errno;
    $errmsg = $conn->error;
    echo "Selection failed with: ($errno) $errmsg<br/>\n";
    $conn->close();
    exit;
} else {
    // Display results in a table
    ?>
    <div class="container wrapper">
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Movies</li>
        </ul>

        <h1 class="text-center">Movies</h1>

        <div class="row">
            <div class="col-xs-4">
                <!-- Filter by Genre -->
                <form action="movies.php" method="get" class="form-inline" role="form" style="text-align: left; margin-bottom: 10px;">
                    <div class="input-group">
                        <label class="sr-only" for="genreFilter">Filter by Genre</label>
                        <div class="input-group-addon"><i class="fa fa-filter fa-lg"></i></div>
                        <select name="genre_id" id="genreFilter" class="form-control">
                            <?php
                            while ($rowGenre = $resultGenres->fetch_assoc()) {
                                $selected = (isset($_GET['genre_id']) && $_GET['genre_id'] == $rowGenre['genre_id']) ? 'selected' : '';
                                echo "<option value='{$rowGenre['genre_id']}' $selected>{$rowGenre['genre_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
            </div>
            <div class="col-xs-8">
                <!-- Search Movies -->
                <form action="searchmovies.php" method="get" class="form-inline search-form" role="form" style="text-align: right; margin-bottom: 10px;">
                    <div class="input-group">
                        <label class="sr-only" for="movieSearch">Search Movies</label>
                        <div class="input-group-addon"><i class="fa fa-search fa-lg"></i></div>
                        <input type="text" name="movie" placeholder="Search" id="movieSearch" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Go!</button>
                </form>
            </div>
        </div>

        <div class="movie-list">
            <?php
            $i = 0;
            while ($result_row = $resultMovies->fetch_assoc()) :
                $i++;
                if ($i == 1) :
                    ?>
                    <div class="row">
                <?php endif; ?>
                <div class="col-xs-4">
                    <div class="thumbnail">
                        <div class="caption">
                            <div class="text-center">
                                <a href="moviedetails.php?id=<?php echo $result_row['movie_id'] ?>">
                                    <img src="<?php echo $result_row['movie_img'] ?>" />
                                </a>
                            </div>
                            <h3 class="text-center">
                                <?php
                                echo "<a href='moviedetails.php?id=" . $result_row['movie_id'] . "'>", $result_row['movie_name'], "</a>";
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <?php if ($i == 3) : ?>
                    </div>
                    <?php $i = 0;
                endif;
            endwhile; ?>
        </div>
    </div>
    <?php
    // Clean up result sets when we're done with them!
    $resultGenres->close();
    $resultMovies->close();
}

// Close the connection.
$conn->close();

include('includes/footer.php');
?>
