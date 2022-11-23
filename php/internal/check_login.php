#!/usr/bin/php
<?php
require 'database_connection.php'

// access level assiciated with user,pass
// -1 if invalid login
public function getLoginAccessLevel($username, $password) {
  if (!isset($username) || !isset($password)) {
    return -1;
  }

  
}
?>
