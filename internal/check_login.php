<?php
require '../database.php';

// access level assiciated with user,pass
// -1 if invalid login
function getLoginAccessLevel($username, $password) {
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

  $actualPassword = $row[0]; // password for user
  $accessLevel = $row[1]; // access level associated with user
  if ($actualPassword == $password) {
    // user authenticated, return access level that user was given
    return $accessLevel;
  }

  // user not authenticated
  return -1;
}
?>
