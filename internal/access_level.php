<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();

require '../database.php';

// access level assiciated with user,pass
// -1 if invalid login
function getAccessLevel($username, $password) {
  // values not set
  if (!isset($username) || !isset($password)) {
    return -1;
  }
  
  require '../database.php';
  
  // get password associated with username
  $stmt = $conn->prepare("SELECT login_password, accessLevel_id FROM Staff WHERE login_username = :username");
  $stmt->bindParam("username", $username);
  $stmt->execute();
  
  $row = $stmt->fetch();
  // user not found
  if ($row == null) {
    return -1;
  }

  $actualPassword = $row[0]; // password for user
  $accessLevel = $row[1]; // access level associated with user
  if ($actualPassword == $password) {
    // user authenticated, return access level that user was given
    return $accessLevel;
  }
  
  // user not authenticated
  return -1;
}


function requireAccessLevel($minLevel) {
  $accessLevel = getAccessLevel($_SESSION['username'], $_SESSION['password']);
  // user not loggged in
  if ($accessLevel == -1) {
    // redirect to login page with GET data which will redirect user back to page
    // once logged in
    header('location: ./login.php?redirect='.$_SERVER['REQUEST_URI']);
  }
  // user dosent have correct access level
  if ($accessLevel > $minLevel) {
    die("unauthorized access");
  }
}


?>