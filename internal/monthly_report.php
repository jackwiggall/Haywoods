<?php

require './access_level.php';
requireAccessLevel(1);


require '../database.php';

$valuesSet = false;

if (isset($_GET["year"]) && isset($_GET["month"])) {
  $valuesSet = true;
  $month = $_GET["month"];
  $year = $_GET["year"];

  // query StaffDetails View to get store_id associated with user
  $stmt = $conn->prepare("SELECT store_id FROM StaffDetails WHERE login_username = :username");
  $stmt->bindParam("username", $_SESSION['username']);
  $stmt->execute();
  $store_id = $stmt->fetch()[0];

  // query CashCardSales View to get Cash and Card sales for specific month
  $cashCardSalesQuery = "SELECT (
                          SELECT SUM(totalCost) FROM CashCardSales
                          WHERE cardPayment_id IS NOT NULL
                          AND store_id = :store_id
                          AND MONTH(date) = :month AND YEAR(date) = :year
                        ) AS cardSales,
                        (
                          SELECT SUM(totalCost) FROM CashCardSales
                          WHERE cashPayment_id IS NOT NULL
                          AND store_id = :store_id
                          AND MONTH(date) = :month AND YEAR(date) = :year
                        ) AS CashSales";
  
  $stmt = $conn->prepare($cashCardSalesQuery);
  $stmt->bindParam("month", $month);
  $stmt->bindParam("year", $year);
  $stmt->bindParam("store_id", $store_id);
  $stmt->execute();
  $row = $stmt->fetch();
  // set to nulls to 0
  $cardSales = ($row[0] == null) ? 0 : $row[0];
  $cashSales = ($row[1] == null) ? 0 : $row[1];
  $totalSales = $cardSales + $cashSales;


  // $topSellersQuery = "SELECT Product.sku_code,name,COUNT(sku_code),date
  //                     FROM Product,Sale GROUP BY sku_code ORDER BY 'value_occurence' DESC
                      
  //                     WHERE MONTH(date) = :month AND YEAR(date) = :year";
  // $stmt = $conn->prepare($topSellersQuery);
  // $stmt->bindParam("month", $month);
  // $stmt->bindParam("year", $year);
  // $stmt->execute();
  // $topSellers = $stmt->fetchAll();


}
// $stmt = $conn->prepare("SELECT sale_id,date,staff_id,totalCost FROM Sale "+$query_where);
//   if (isset($_POST['date']))  $stmt->bindParam("date", $_POST['date']);
//   if (isset($_POST['store'])) $stmt->bindParam("store", $_POST['store']);

//   $stmt->execute();

//   while (($store = $stmt->fetch()) != null) {

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Monthly Report</title>
    <link rel="stylesheet" href="../styles.css">
  </head>
  
  <body>
    <?php require './login_banner.php'; ?>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Monthly Report</h1>

      <div class="container border border-dark bg-info p-2 mb-2">
        <form action="" method="get">
          Monthly Report for 
          <select name="year">
            <?php
              $year = date("Y");
              $currentYear = (isset($_GET['year'])) ? $_GET['year'] : $year;
              for ($i = $year-5; $i <= $year; $i++) {
                $selected = "";
                if ($i == $currentYear) $selected = "selected";
                echo "<option value='$i' $selected>$i</option>";
              }
            ?>
          </select>
          <select name="month">
            <?php
              $months = array("January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
              $currentMonth = (isset($_GET['month'])) ? $_GET['month'] : date("m");
              for ($i=1; $i<13; $i++) {
                $selected = "";
                if ($i == $currentMonth) $selected = "selected";
                echo "<option value='$i' $selected>".$months[$i-1]."</option>";
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

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Sale Details</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Cash Sales</th>
            <th>Card Sales</th>
            <th>Total</th>
          </tr>
          <tr>
            <?php
              echo "<td>$cashSales</td>";
              echo "<td>$cardSales</td>";
              echo "<th>$totalSales</th>";
            ?>
          </tr>
        </table>
      </div>

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Top 5 Sellers</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Name</th>
            <th>SKU Code</th>
            <th>Sold</th>
          </tr>
          <tr> <!--1 of 5-->
            <td>TV Stand</td>
            <td>125160</td>
            <td>20</td>
          </tr>
          <tr> <!--2 of 5-->
            <td>Bedside Cabinet</td>
            <td>123012</td>
            <td>16</td>
          </tr>
          <tr> <!--3 of 5-->
            <td>Bed Frame</td>
            <td>124019</td>
            <td>15</td>
          </tr>
          <tr> <!--4 of 5-->
            <td>Table</td>
            <td>121022</td>
            <td>14</td>
          </tr>
          <tr> <!--5 of 5-->
            <td>Sofa</td>
            <td>125159</td>
            <td>12</td>
          </tr>
        </table>
      </div>

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Employee Pay</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Hours</th>
            <th>Pay</th>
          </tr>
          <tr>
            <td>520</td>
            <td>£4732.00</td>
          </tr>
        </table>
      </div>


    </div>
  </body>

</html>
