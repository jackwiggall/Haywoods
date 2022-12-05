<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE)
  session_start();

require 'access_level.php';
requireAccessLevel(4);

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
        <h1 class="w3-jumbo"><b>Haywoods Internal</b></h1>
        <!--Page Title-->
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <p>This part of the website will only be hosted on the Haywoods internal intranet and will not be accessible to
          the public
        </p>
      </div>

      <!-- End page content -->
    </div>

  </body>

</html>