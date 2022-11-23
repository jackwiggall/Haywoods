<?php

function getDatabaseConn() {
  // database login details
  $dbhost = "127.0.0.1"; // change to silvia.computing.dundee.ac.uk
  $dbuser = "22ac3u03";
  $dbpass = "ac31b2";
  $dbname = "22ac3d03";
  
  // Create connection
  try {
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  } catch (mysqli_sql_exception $e) {
    // error connecting to database, return null object
    return null;
  }

  return $conn;
}
?>
