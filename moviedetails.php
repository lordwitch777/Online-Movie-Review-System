<?php
require_once('includes/database.php');
session_start();
$id = $_GET['id'];
$loggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
$isAdmin = $loggedIn && isset($_SESSION['role']) && $_SESSION['role'] == 1;

// Select statement for movie details and genres
$query_str = "SELECT m.*, GROUP_CONCAT(g.genre_name SEPARATOR ', ') AS genre_names
              FROM $tblMovies AS m
              LEFT JOIN movie_genres AS mg ON m.movie_id = mg.movie_id
              LEFT JOIN genres AS g ON mg.genre_id = g.genre_id
              WHERE m.movie_id = '$id'
              GROUP BY m.movie_id";

$result = $conn->query($query_str);

$review_str = "SELECT review_id, review_rating, review_content FROM $tblReviews WHERE review_movie_id = '$id'";
if ($loggedIn) {
    $review_str .= " AND review_user_id = " . $_SESSION['user_id'];
}
$review_result = $conn->query($review_str);

if (!$result || !$review_result) {
    $errno = $conn->errno;
    $errmsg = $conn->error;
    echo "Selection failed with: ($errno) $errmsg<br/>\n";
    $conn->close();
    exit;
} else {
    $result_row = $result->fetch_assoc();
    $page_title = "CineCritique: " . $result_row['movie_name'];
    require_once('includes/header.php');
?>

<div class="container wrapper">
    <div class="row">
        <div class="col-xs-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li><a href="movies.php">Movies</a></li>
                <li class="active"><?php echo $result_row['movie_name'] ?></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <h1><?php echo $result_row['movie_name'] ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <img class="img-responsive" src="<?php echo $result_row['movie_img']; ?>" alt=""/>
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    // Display genres
                    if (!empty($result_row['genre_names'])) {
                        echo '<h3>Genre: ' . $result_row['genre_names'] . '</h3>';
                    }
                    ?>
                    <h3>Year: <?php echo $result_row['movie_year'] ?></h3>
                    <h3>Movie Rating: <?php echo $result_row['movie_rating'] ?></h3>
                    <p class="lead"><?php echo $result_row['movie_bio'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    $totalRating = 0;
                    $numReviews = $review_result->num_rows;

                    while ($review_result_row = $review_result->fetch_assoc()) {
                    ?>
                        <div class="review-section">
                            <h3 class="<?php
                                if ($review_result_row['review_rating'] > 4) {
                                    echo 'text-success';
                                } elseif ($review_result_row['review_rating'] < 2) {
                                    echo 'text-danger';
                                }
                                ?>">Review Rating: <?php echo $review_result_row['review_rating'] ?></h3>
                            <p class="lead">Review: <br/><?php echo $review_result_row['review_content'] ?></p>
                        </div>
                    <?php
                        $totalRating += $review_result_row['review_rating'];
                    }

                    $averageRating = ($numReviews > 0) ? round($totalRating / $numReviews, 2) : 0;
                    ?>
                    <h3>Average Rating: <?php echo $averageRating; ?></h3>

                    <?php
                    $review_result->data_seek(0);

                    if ($loggedIn && $review_result->num_rows > 0) {
                    ?>
                        <a class="btn btn-warning" href="editreview.php?id=<?php echo $result_row['movie_id']; ?>">EDIT REVIEW <i class="fa fa-edit"></i></a>
                    <?php
                    }

                    if ($isAdmin) {
                    ?>
                        <a class="btn btn-danger" href="deletemovie.php?id=<?php echo $result_row['movie_id']; ?>">DELETE MOVIE <i class="fa fa-close"></i></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php if (empty($login)) { ?>
                <p class="lead"><a href="loginform.php">Sign in</a> or <a href="registration.php">register</a> to leave a review or make this a favorite movie!</p>
            <?php } else { ?>
                <p>
                    <a class="btn btn-info" href="addreview.php?id=<?php echo $result_row['movie_id'] ?>" role="button">ADD REVIEW <i class="fa fa-plus"></i></a>
                </p>
                <p>
                    <a class="btn btn-success" href="addtoaccount.php?id=<?php echo $result_row['movie_id'] ?>" role="button">FAVORITE <i class="fa fa-angle-double-right fa-lg"></i></a>
                </p>
                <?php if ($role == 1) : ?>
                    <a class="btn btn-danger" href="deletemovie.php?id=<?php echo $result_row['movie_id']; ?>">DELETE MOVIE <i class="fa fa-close"></i></a>
                <?php endif; ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    $conn->close();
    include_once('includes/footer.php');
}
?>
