<?php
// Check if the login form has been submitted
if (isset($_POST['login'])) {
  // Get the username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Connect to the database
  $conn = new mysqli('localhost','root','','registration');

  // Query the database to get the user with the matching username and password
  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  // Check if the query returned a row
  if (mysqli_num_rows($result) == 1) {
    // The user has successfully logged in, redirect to the homepage
    header("Location: Games1.html");
    exit();
  } else {
    // Set the error message in the error message container
    echo '<script>document.getElementById("error-message").innerHTML = "Invalid username or password";</script>';
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
