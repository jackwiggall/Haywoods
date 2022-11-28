<?php

require '../database.php';

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT location, accessLevelName, firstname, lastname FROM StaffDetails WHERE login_username = :username");
$stmt->bindParam("username", $username);
$stmt->execute();
$row = $stmt->fetch();

$store_location = $row[0];
$accessLevelName = $row[1];
$firstname = $row[2];
$lastname = $row[3];


?>


<div>
  <div class="row ps-2 pe-2 pt-1">
    <div class="col-2">
      <a href=".">Home</a>
    </div>
    <div class="col text-center">
      <?php
        echo "$firstname $lastname ($username), $accessLevelName, <strong>$store_location</strong>";
      ?>
    </div>
    <div class="col-2 text-end me-2">
      <a href='./login.php?logout=true'>Logout</a>
    </div>

  </div>
</div>
