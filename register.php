<?php
//start a new session
session_start();

$page_title = "Register New Account";

require_once 'includes/header.php';
require_once 'includes/database.php';

$user_name = $_GET['username'];
$full_name = $_GET['name'];
$user_email = $_GET['email'];
$password = $_GET['password'];
$role = $_GET['role'];

//define sql statement
$query_str = "INSERT INTO users VALUES (NULL, '$user_name', '$full_name', '$user_email', '$password', '$role')";

//execute the query
$result = @$conn->query($query_str);

//handle error
if(!$result) {
  $errno = $conn->errno;
  $errmsg = $conn->error;
  echo "Insertion failed with: ($errno) $errmsg<br/>\n";
  $conn->close();
  exit;
}



$query_stry = "SELECT * FROM users WHERE user_name='$user_name' AND user_password='$password'";

//Execute the query
$result = @$conn->query($query_stry);
if($result -> num_rows) {

  //It is a valid user. Need to store the user in Session Variables
  @session_start();
  $_SESSION['login'] = $user_name;
  $result_row = $result->fetch_assoc();
  $_SESSION['role'] = $result_row['user_role'];
  $_SESSION['name'] = $result_row['user_full_name'];
  $_SESSION['id'] = $result_row['user_id'];

  //update the login status
  $login_status = 1;
  ?>

  <div class="container wrapper">
    <h1 class="text-center text-success">You have successfully registered!</h1>
  </div>

<?php
}

header( "Refresh:3; url=useraccount.php", true, 303);
include ('includes/footer.php');
?>