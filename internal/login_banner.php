<?php

require '../database.php';

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT Store.location,Staff.firstname,Staff.lastname,AccessLevel.name
                        FROM Store,Staff,AccessLevel
                        WHERE Staff.store_id = Store.store_id
                        AND Staff.accessLevel_id = AccessLevel.accessLevel_id
                        AND Staff.login_username = :username");
$stmt->bindParam("username", $username);
$stmt->execute();
$row = $stmt->fetch();

$store_location = $row[0];
$firstname = $row[1];
$lastname = $row[2];
$accessLevelName = $row[3];


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
