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
        <h1 class="w3-jumbo"><b>Access Denied</b></h1>
        <!--Page Title-->
        <h1 class="w3-xxxlarge w3-red"><b>Invalid Request.</b></h1>
        <!--Sub title-->
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <?php
        $username = $_SESSION['username'];
        echo "User $username does not have the permission level to view this page.<br>";
        ?>
      </div>

      <!-- End page content -->
    </div>

  </body>

</html>