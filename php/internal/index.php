<?php
session_start();


require 'check_login.php';

$username = $_SESSION['username'];
$accessLevel = getLoginAccessLevel($_SESSION['username'], $_SESSION['password']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Interal Index</title>
</head>
<body>
  <!-- <?php require 'login_banner.php'; ?> -->
  <h1>
    <?php
      if (isset($username)) {
        echo "logged in as $username with access level $accessLevel";
        echo "<a href='/internal/login.php?logout=true&redirect=/internal/index.php'>Logout</a>";
      } else {
        echo "not logged in ";
        echo "<a href='/internal/login.php?redirect=/internal/index.php'>login</a>";
      }
    ?>
  </h1>

  <div>
    <h3>Internal links</h3>
    <?php
      if ($accessLevel != -1) { // hide links for user not logged in
        if ($accessLevel <= 4) { // trainee
          echo '<li><a href="/internal/till.php">Till</a></li>';
        }
        if ($accessLevel <= 3) { // employee
          echo '<li><a href="/internal/product_history.php">Product History</a></li>';
        }
        if ($accessLevel <= 2) { // supervisor
          echo '<li><a href="/internal/sale_history.php">Sale History</a></li>';
        }
        if ($accessLevel == 1) { // management
          echo '<li><a href="/internal/monthly_report.php">Monthly Report</a></li>';
        }
      }
    ?>
  </div>
</body>
</html>