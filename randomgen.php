<!DOCTYPE html>
<html>
<head>
  <title>Random Movie Generator</title>
  <style>
    .center {
      text-align: center;
      margin-top: 100px;
    }

    .movie-img {
      width: 250px;
      height: 400px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="center">
    <?php
    require_once('includes/header.php');

    function getRandomMovie()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "jayrolex";

        // Create a database connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get a random movie name from the database.
        $sql = 'SELECT movie_id, movie_name, movie_img FROM movies ORDER BY RAND() LIMIT 1';
        $result = $conn->query($sql);

        // Check if there are any movies in the database.
        if ($result->num_rows > 0) {
            $randomMovie = $result->fetch_assoc();
        } else {
            $randomMovie = ['movie_name' => 'No movies found.', 'movie_img' => ''];
        }

        // Close the database connection.
        $conn->close();

        // Return the random movie name and image path.
        return $randomMovie;
    }

    // Generate a random movie name and image path.
    $randomMovie = getRandomMovie();

    // Display the random movie name and image on the page.
    echo "<p>Your random movie is: <strong>{$randomMovie['movie_name']}</strong></p>";
    if (isset($randomMovie['movie_id'])) {
        echo "<a href='moviedetails.php?id={$randomMovie['movie_id']}'>";
        echo "<img class='movie-img' src='{$randomMovie['movie_img']}' alt='{$randomMovie['movie_name']}'>";
        echo "</a>";
    } else {
        echo "<p>{$randomMovie['movie_name']}</p>";
    }
    include('includes/footer.php');
    ?>
  </div>
</body>
</html>
