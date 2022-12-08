<?php

require './access_level.php';
requireAccessLevel(4);

require '../database.php';

$valuesSet = false;

// 1% hard coded commission
$COMMISSION_FACTOR = 0.01;

if (isset($_GET["year"]) && isset($_GET["month"])) {
  $valuesSet = true;
  $workedHoursQuery = "SELECT staffPay, SUM(COALESCE(shiftHours,0)) AS totalHours, SUM(COALESCE(shiftPay,0)) AS totalPay
            FROM vStaffShifts
            WHERE MONTH(shiftDate) = :month AND YEAR(shiftDate) = :year
            AND staff_id = :staff_id";

  $stmt = $conn->prepare($workedHoursQuery);

  $stmt->bindParam("month", $_GET['month']);
  $stmt->bindParam("year", $_GET['year']);
  $stmt->bindParam("staff_id", $_SESSION['staff_id']);
  $stmt->execute();
  $row = $stmt->fetch();

  $worked_hours = $row['totalHours'];
  $hourly_wage = $row['staffPay'];
  $pay_hours = $row['totalPay'];

  $commissionQuery = "SELECT SUM(COALESCE(totalCost,0)) AS sumSales FROM vCommission
                      WHERE MONTH(date) = :month AND YEAR(date) = :year
                      AND staff_id = :staff_id";
  $stmt = $conn->prepare($commissionQuery);
  $stmt->bindParam("month", $_GET['month']);
  $stmt->bindParam("year", $_GET['year']);
  $stmt->bindParam("staff_id", $_SESSION['staff_id']);
  $stmt->execute();
  $row = $stmt->fetch();

  $pay_commission = $row['sumSales'] * $COMMISSION_FACTOR;


  $pay_total = $pay_hours + $pay_commission;
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Haywoods | Monthly Pay Details</title>
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
        <h1 class="w3-jumbo"><b>Monthly Pay Details</b></h1>
        <!--Page Title-->
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <div class="container border border-dark bg-primary text-white dropshadow p-2 mb-2">
          <form action="" method="get">
            Pay Details for
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
            <input type="submit" value="Fetch">
          </form>
        </div>

        <?php
        // dont show anything if submit button not pressed
        if (!$valuesSet) {
          die("</div></body></html>");
        }
        ?>
        <div class="container border border-dark bg-primary dropshadow p-2 mb-2">
          <h3 class="p-3 border border-dark bg-light">Details - <?php echo $_SESSION['fullname'] ?></h3>
          <table class="table table-bordered border-dark bg-light">
            <tr>
              <th>Worked Hours</th>
              <th>Hourly Wage</th>
              <th>Pay (Hours)</th>
              <th>Pay (Commission)</th>
              <th>Pay (Total)</th>
            </tr>
            <tr>
              <?php
              echo "<td>" . number_format($worked_hours, 1) . "</td>";
              echo "<td>£" . number_format($hourly_wage, 2) . "</td>";
              echo "<td>£" . number_format($pay_hours, 2) . "</td>";
              echo "<td>£" . number_format($pay_commission, 2) . "</td>";
              echo "<td>£" . number_format($pay_total, 2) . "</td>";
              ?>
            </tr>
          </table>
        </div>

  </body>

</html>