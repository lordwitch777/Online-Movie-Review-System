<!DOCTYPE html>
<html>

<?php
$page_title = "CineCritique";
include_once('includes/header.php');
?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="assets/img/lotr.jpg" alt="First slide">
            <div class="jumbotron">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>CineCritique </h1>
                        <p>Welcome to the CineCritique Movie Review and Rating Service!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="assets/img/pacific-rim.jpg" alt="Second slide">
            <div class="jumbotron">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>View Movies</h1>
                        <?php
                        // Check if the user is logged in
                        if (!isset($_SESSION['login'])) {
                            // If not logged in, show the create account option
                            echo '<p>Create an account to review your favorite movies</p>';
                            echo '<p><a class="btn btn-lg btn-info" href="registration.php" role="button">Sign up today</a></p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="assets/img/dist9.jpg" alt="Third slide">
            <div class="jumbotron">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Read Reviews</h1>
                        <p>Browse all of our reviews and find out more about what others thought of your favorite movies!</p>
                        <p><a class="btn btn-lg btn-info" href="reviews.php" role="button">VIEW REVIEWS &raquo;</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.carousel -->

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <?php
        // Check if the user is logged in
        if (!isset($_SESSION['login'])) {
            // If not logged in, show the create account option
            echo '<div class="col-md-4">';
            echo '<h2>CREATE ACCOUNT</h2>';
            echo '<p>Sign up for an account in order to add a review to your favorite movie</p>';
            echo '<p><a class="btn btn-default" href="registration.php" role="button">SIGN UP &raquo;</a></p>';
            echo '</div>';
        }

        // Check if the user is an admin
        if (isset($_SESSION['login']) && $_SESSION['role'] == 1) {
            // If admin, show the User List button
            echo '<div class="col-md-4">';
            echo '<h2>USER LIST</h2>';
            echo '<p>View and manage user accounts</p>';
            echo '<p><a class="btn btn-default" href="user_list.php" role="button">USER LIST &raquo;</a></p>';
            echo '</div>';
        }

        // Check if the user is logged in
        if (isset($_SESSION['login'])) {
            // If logged in, show the "My Reviews" link
            echo '<div class="col-md-4">';
            echo '<h2>My Reviews</h2>';
            echo '<p>View reviews submitted by you</p>';
            echo '<p><a class="btn btn-default" href="user_review.php" role="button">VIEW MY REVIEWS &raquo;</a></p>';
            echo '</div>';
        }

        // Add the button for generating a random movie
        echo '<div class="col-md-4">';
        echo '<h2>GET A RANDOM MOVIE</h2>';
        echo '<p>Get a random movie suggestion</p>';
        echo '<p><a class="btn btn-default" href="randomgen.php" role="button">GENERATE MOVIE &raquo;</a></p>';
        echo '</div>';
        ?>
        <div class="col-md-4">
            <h2>LIST MOVIES</h2>
            <p>Browse our extensive list of movie titles along with ratings, years, a short synopsis, and even reviews!</p>
            <p><a class="btn btn-default" href="movies.php" role="button">VIEW MOVIES &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>LIST REVIEWS</h2>
            <p>Browse all of our reviews and find out more about what others thought of your favorite movies!</p>
            <p><a class="btn btn-default" href="reviews.php" role="button">VIEW REVIEWS &raquo;</a></p>
        </div>
    </div>
</div> <!-- /container -->
</html>

<?php
include_once('includes/footer.php');
?>
