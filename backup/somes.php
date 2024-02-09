<?php

function getRandomMovieFromDatabase() {
  // Connect to the database.
  $db = new PDO('mysql:host=localhost;dbname=rand', 'root', '');

  // Get a random movie name from the database.
  $sql = 'SELECT name FROM rand ORDER BY RAND() LIMIT 1';
  $result = $db->query($sql);
  $randomMovie = $result->fetchColumn();

  // Close the database connection.
  $db = null;

  return $randomMovie;
}

$randomMovie = getRandomMovieFromDatabase();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Random Movie Picker</title>
</head>
<body>

  <h1>Random Movie Picker</h1>

  <p>Your random movie is: <?php echo $randomMovie; ?></p>

</body>
</html>


<?php
 $db_host = "localhost";
 $db_user = "root";
 $db_pass = "";
 $db_name = "jayrolex";
function showRandomMovie() 
{
 
  
// Connect to the database
$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

// Get a random movie from the database
$query = 'SELECT movie_name, movie_img FROM movies ORDER BY RAND() LIMIT 1';
$result = $db->query($query);
?>
<html>
  <body>
    <?php
// Check if the mysqli_result object is empty
if ($result === false) {
  echo 'Error executing query: ' . $db->errorInfo()[2];
  exit();
}

// Check if the fetch() method is being called correctly
if ($randomMovie = $result->fetch()) {
  echo '<img src="' . $randomMovie['movie_img'] . '" alt="' . $randomMovie['movie_name'] . '">';
  echo '<br>';
  echo $randomMovie['movie_name'];
} else {
  echo 'Error fetching random movie';
}
}
?>
</body>
</html>