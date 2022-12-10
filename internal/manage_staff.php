<?php

require './access_level.php';
requireAccessLevel(1);

require '../database.php';

$valuesSet = false;


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
        <h1 class="w3-jumbo"><b>Monthly Report</b></h1>
        <!--Page Title-->
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <div class="container border border-dark bg-primary text-white dropshadow p-2 mb-2">
          <form action="" method="get">
            Monthly Report for
            <select name="year">
              <?php
              $year = date("Y");
              $currentYear = (isset($_GET['year'])) ? $_GET['year'] : $year;
              for ($i = $year - 5; $i <= $year; $i++) {
                $selected = "";
                if ($i == $currentYear)
                  $selected = "selected";
                echo "<option value='$i' $selected>$i</option>";
              }
              ?>
            </select>
            <select name="month">
              <?php
              $months = array("January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
              $currentMonth = (isset($_GET['month'])) ? $_GET['month'] : date("m");
              for ($i = 1; $i < 13; $i++) {
                $selected = "";
                if ($i == $currentMonth)
                  $selected = "selected";
                echo "<option value='$i' $selected>" . $months[$i - 1] . "</option>";
              }
              ?>
            </select>
            <input type="submit" value="Search">
          </form>
        </div>

        <?php
        // dont show anything if submit button not pressed
        if (!$valuesSet) {
          die("</div></body></html>");
        }
        ?>

        <div class="container border border-dark bg-primary dropshadow p-2 mb-2">
          <h3 class="p-3 border border-dark bg-light">Sale Details</h3>
          <table class="table table-bordered border-dark bg-light">
            <tr>
              <th>Cash Sales</th>
              <th>Card Sales</th>
              <th>Total</th>
            </tr>
            <tr>
              <?php
              echo "<td>£$cashSales (x$cashCount)</td>";
              echo "<td>£$cardSales (x$cardCount)</td>";
              echo "<th>£$totalSales (x$totalCount)</th>";
              ?>
            </tr>
          </table>
        </div>

        <div class="container border border-dark bg-primary dropshadow p-2 mb-2">
          <h3 class="p-3 border border-dark bg-light">Top Sellers</h3>
          <table class="table table-bordered border-dark bg-light">
            <tr>
              <th>SKU Code</th>
              <th>Name</th>
              <th>Sold</th>
            </tr>
            <?php
            foreach ($topSellers as $topSeller) {
              echo "<tr>";
              echo "<td>" . $topSeller['sku_code'] . "</td>";
              echo "<td>" . $topSeller['name'] . "</td>";
              echo "<td>" . $topSeller['quantity'] . "</td>";
              echo "</tr>";
            }
            ?>
          </table>
        </div>

        <div class="container border border-dark bg-primary dropshadow p-2 mb-2">
          <h3 class="p-3 border border-dark bg-light">Employee Pay</h3>
          <table class="table table-bordered border-dark bg-light">
            <tr>
              <th>Hours</th>
              <th>Pay</th>
            </tr>
            <tr>
              <?php
              echo "<td>$totalHours</td>";
              echo "<td>£$totalPay</td>";
              ?>
            </tr>
          </table>
        </div>
      </div>

      <!-- End page content -->
    </div>

  </body>

</html>