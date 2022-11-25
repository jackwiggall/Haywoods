<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Haywoods</title>
    <link rel="stylesheet" href="../styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Access Denied</h1>

      <!--Red warning box-->
      <div class="container border border-dark bg-danger text-white p-3 mb-2">
        <?php
          echo "User $username does not have the permission level to view this page,<br>";
          echo "User has Access $accessLevel,<br>";
          echo "Page requires Access $accessLevel.<br>"; #change var
         ?>
      </div>
      <a href="./"><button value="Home" class="btn btn-primary border border-dark f-r w300">Home</button></a> <!--Might need to change dest-->
    </div>
  </body>

</html>
