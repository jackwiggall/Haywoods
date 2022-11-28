<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();


function requireAccessLevel($minLevel) {
  if (!$_SESSION['loggedIn']) {
    // user not logged in, redirect to login page which will redirect them back
    // to the original page after authenticated
    header('location: ./login.php?redirect='.$_SERVER['REQUEST_URI']);
    die();
  }

  if ($minLevel < $_SESSION['accessLevel']) {
    // user not allowed to view page, show unauthorized access page
    die("unauthorized access");
  }

  // user is allowed to access page, continue executing php and render page to
  // them
}


?>