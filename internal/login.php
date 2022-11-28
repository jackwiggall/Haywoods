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
<html lang="en">
<head>
<title>Haywoods</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar bg-primary w3-collapse w3-top w3-large w3-padding text-white" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Haywoods<br>Internal</b></h3>
  </div>
  <div class="w3-bar-block"> <!--Check access level? Add login/logout on bar? may need to change addresses-->
    <a href="../index.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> <!--Index-->
    <a href="../product_search.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Product Search</a> <!-- -->
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large text-primary w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button text-primary w3-margin-right" onclick="w3_open()">☰</a>
  <span>Haywoods</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px">
    <h1 class="w3-jumbo"><b>Login to internal site</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>Enter Details.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
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

<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
