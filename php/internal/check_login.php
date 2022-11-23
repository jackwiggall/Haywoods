<?php
require '../database_connection.php';

// access level assiciated with user,pass
// -1 if invalid login
function getLoginAccessLevel($username, $password) {
  // values not set
  if (!isset($username) || !isset($password)) {
    return -1;
  }

  $conn = getDatabaseConn();
  
  // get password associated with username
  $username_escaped = $conn->real_escape_string($username);
  try {
    $res = $conn->query("SELECT login_password, accessLevel_id FROM Staff WHERE login_username = '$username_escaped'");
  } catch (mysqli_sql_exception $e) {
    // user not found
    return -1;
  }

  $row = $res->fetch_row();
  $conn->close(); // close database connection

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
