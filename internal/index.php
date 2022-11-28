<?php
// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();

require 'access_level.php';
requireAccessLevel(4);


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
  <?php require 'login_banner.php'; ?>
  <div class="container">
    <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Internal</h1>
   
    <div class="container border border-dark bg-info p-2 mb-2">
      <div class="row">
        <?php
          if ($_SESSION['accessLevel'] <= 4) { // trainee
            echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./till.php">Till</a></div>';
          }
          if ($_SESSION['accessLevel'] <= 3) { // employee
            echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./product_history.php">Product History</a></div>';
          }
          if ($_SESSION['accessLevel'] <= 2) { // supervisor
            echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./sale_history.php">Sale History</a></div>';
          }
          if ($_SESSION['accessLevel'] == 1) { // management
            echo '<div class="col bg-light border border-dark m-2 p-2 text-center"><a href="./monthly_report.php">Monthly Report</a></div>';
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
