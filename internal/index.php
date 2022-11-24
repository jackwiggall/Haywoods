<?php
session_start();

require 'access_level.php';

$accessLevel = -1;
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
  $username = $_SESSION['username'];
  $accessLevel = getAccessLevel($_SESSION['username'], $_SESSION['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <title>Haywoods Internal</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Internal</h1>
    <!-- <?php require 'login_banner.php'; ?> -->
    <h3 class="p-3 mb-5">
      <?php
        if ($accessLevel != -1) {
          echo "User: $username, Access: $accessLevel";
          echo "<a class='f-r' href='./login.php?logout=true&redirect=./index.php'>Logout</a>";
        } else {
          #echo "Sign in: ";
          echo "<a class='f-r' href='./login.php?redirect=./index.php'>Login</a>";
        }
      ?>
    </h3>

    <?php
      if ($accessLevel != -1) {
        echo '<div class="container border border-dark bg-info p-2 mb-2">';
        echo '<div class="row">';
        if ($accessLevel <= 4) { // trainee
          echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./till.php">Till</a></div>';
        }
        if ($accessLevel <= 3) { // employee
          echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./product_history.php">Product History</a></div>';
        }
        if ($accessLevel <= 2) { // supervisor
          echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./sale_history.php">Sale History</a></div>';
        }
        if ($accessLevel == 1) { // management
          echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./monthly_report.php">Monthly Report</a></div>';
        }
        echo '</div>';
        echo '</div>';
      }
    ?>
  </div>
</body>
</html>
