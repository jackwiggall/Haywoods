<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();


require './access_level.php';


function performRedirection() {
  $redirection = $_GET["redirect"];
  if (isset($redirection)) {
    header("location: $redirection");
    die();
  } else {
    header('location: /Haywoods/internal/index.php');
    die();
  }
}


// logout request
if (isset($_GET['logout']) && $_GET['logout'] == "true") {
  session_destroy(); // clear login cookies
  performRedirection();
}

$invalidLogin = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $access_level = getAccessLevel($username, $password);
  // user not found on system
  // echo "<br>access level $access_level for $username: $password<br>";
  if ($access_level == -1) {
    $invalidLogin = true;
  } else {
    // login successfull, save details to cookie to be used again
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    // redirect to different page
    performRedirection();
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
          if ($invalidLogin) {
            echo '<h1>failed</h1>';
          }
        ?>
      </div>

    </div>
  </body>

</html>
