<?php

// database login details
// $dbhost = "127.0.0.1"; // change to silva.computing.dundee.ac.uk
$dbhost = "silva.computing.dundee.ac.uk";
$dbuser = "22ac3u03";
$dbpass = "ac31b2";
$dbname = "22ac3d03";

// Create connection
try {
  $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
  // error connecting to database, return null object
  die("database error");
}
