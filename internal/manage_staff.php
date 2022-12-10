<?php

require './access_level.php';
requireAccessLevel(1);

require '../database.php';

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $newFirstname = $_POST['firstname'];
  $newLastname = $_POST['lastname'];
  $stmt = $conn->prepare("UPDATE vStaffDetails
                          SET firstname = :firstname, lastname = :lastname
                          WHERE store_id = :store_id
                          AND login_username = :username");
  $stmt->bindParam("store_id", $_SESSION['store_id']);
  $stmt->bindParam("username", $username);
  $stmt->bindParam("firstname", $newFirstname);
  $stmt->bindParam("lastname", $newLastname);
  $stmt->execute();
}

$stmt = $conn->prepare("SELECT firstname,lastname, login_username, accessLevelName
                        FROM vStaffDetails
                        WHERE store_id = :store_id
                        ORDER BY firstname, lastname");
$stmt->bindParam("store_id", $_SESSION['store_id']);
$stmt->execute();
$staffMembers = $stmt->fetchAll();

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
    <?php require './internal_sidebar.php'; ?>


    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:340px;margin-right:40px">

      <!-- Header -->
      <div class="w3-container" style="margin-top:80px">
        <h1 class="w3-jumbo"><b>Staff Details</b></h1>
        <!--Page Title-->


        <div class="container border border-dark bg-primary dropshadow p-2 mb-2">
          <h3 class="p-3 border border-dark bg-light">Sale Details</h3>
          <table class="table table-bordered border-dark bg-light">
            <tr>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Login Username</th>
              <th>Role</th>
              <th>Apply Changes</th>
            </tr>
            <?php
            foreach ($staffMembers as $staffMember) {
              echo "<tr>";
              echo '<form method="POST">';
              echo '<td><input name="firstname" type="text" style="width: 120px;" value="' . $staffMember['firstname'] . '"></td>';
              echo '<td><input name="lastname" type="text" style="width: 120px;" value="' . $staffMember['lastname'] . '"></td>';
              echo '<input name="username" type="text" value="' . $staffMember['login_username'] . '" hidden>';
              echo '<td>' . $staffMember['login_username'] . '</td>';
              echo '<td>' . $staffMember['accessLevelName'] . '</td>';
              echo '<td class="text-center"><input name="edit" type="submit" class="btn bg-warning" value="Apply Changes"></td>';
              echo '</form>';
              echo "</tr>";
            }
            ?>

          </table>
        </div>
      </div>

      <!-- End page content -->
    </div>

  </body>

</html>