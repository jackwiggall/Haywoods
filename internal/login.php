<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();

require '../database.php';


// function to redirect to page after authentication
function performRedirection() {
  $redirection = $_GET["redirect"];
  if (isset($redirection)) {
    header("location: $redirection");
    die();
  } else {
    // no redirection field set, redirect to index page
    header('location: ./index.php');
    die();
  }
}


// logout request
if (isset($_GET['logout']) && $_GET['logout'] == "true") {
  session_destroy(); // clear login cookies
  performRedirection(); // redirect
}

$errorMessage = "";
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT store_id, storeLocation, accessLevel, accessLevelName, fullname, login_username, login_password
                          FROM StaffLogin WHERE login_username = :username");
  $stmt->bindParam("username", $username);
  $stmt->execute();

  $row = $stmt->fetch();

  $_SESSION['loggedIn'] = false;
  if ($row == null) { // user not found on database
    // set bool flag to display error message that login was unsuccessful
    $errorMessage = "Invalid Username";
  } else {
    $actualPassword = $row['login_password'];
    if ($actualPassword != $password) {
      $errorMessage = "Invalid Password";
    } else {
      // login successfull, save details to cookie
      $_SESSION['loggedIn'] = true;
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['username'] = $row['login_username'];
      $_SESSION['location'] = $row['storeLocation'];
      $_SESSION['store_id'] = $row['store_id'];
      $_SESSION['accessLevel'] = $row['accessLevel'];
      $_SESSION['accessLevelName'] = $row['accessLevelName'];
  
      // redirect to different page
      performRedirection();
    }
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Haywoods</title>
    <link rel="stylesheet" href="../styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Login</h1>

      <div class="container border border-dark bg-info p-2 mb-2">
        <!--<h3 class="p-3 border border-dark bg-light">Enter Details</h3>-->
        <form action="" method="POST">

          <p class="d-inline-block border border-dark bg-light p-2">Username:</p> <input type="text" class="bg-light p-2" required name="username"><br>
          <p class="d-inline-block border border-dark bg-light p-2">Password:</p> <input type="text" class="bg-light p-2" required name="password"><br>

          <input type="submit" value="Login" class="btn btn-primary mt-1 border border-dark w300">
        </form>
        <?php
          if (!empty($errorMessage)) {
            echo "<h1>$errorMessage</h1>";
          }
        ?>
      </div>

    </div>
  </body>

</html>
