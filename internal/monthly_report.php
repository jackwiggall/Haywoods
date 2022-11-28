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

  // query TopSellers View to get the top 5 selling items
  $topSellersQuery = "SELECT sku_code, name, quantity
                      FROM TopSellers
                      WHERE store_id = :store_id AND
                      MONTH(date) = :month AND YEAR(date) = :year
                      LIMIT 5";
  $stmt = $conn->prepare($topSellersQuery);
  $stmt->bindParam("month", $month);
  $stmt->bindParam("year", $year);
  $stmt->bindParam("store_id", $store_id);
  $stmt->execute();
  $topSellers = $stmt->fetchAll();


}
// $stmt = $conn->prepare("SELECT sale_id,date,staff_id,totalCost FROM Sale "+$query_where);
//   if (isset($_POST['date']))  $stmt->bindParam("date", $_POST['date']);
//   if (isset($_POST['store'])) $stmt->bindParam("store", $_POST['store']);

//   $stmt->execute();

//   while (($store = $stmt->fetch()) != null) {

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
<nav class="w3-sidebar bg-primary w3-collapse w3-top w3-large w3-padding text-white" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Haywoods<br>Internal</b></h3>
  </div>
  <?php
    if($accessLevel != -1){
      echo"<a href='./login.php?logout=true' class='w3-bar-item w3-button w3-hover-white'>User: $username, Access: $accessLevel</a>";
    }else{
      echo "<a href='./login.php' class='w3-bar-item w3-button w3-hover-white'>Login</a>";}
  ?> <!--logout/login-->
  <div class="w3-bar-block"> <!--Check access level? Add login/logout on bar? may need to change addresses-->
    <a href="./index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> <!--Index-->
    <?php
      if ($accessLevel <= 4) { // trainee
        echo "<a href='./till.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Till</a>";
      }
      if ($accessLevel <= 3) { // employee
        echo "<a href='./product_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Product History</a>";
      }
      if ($accessLevel <= 2) { // supervisor
        echo "<a href='./sale_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Sale History</a>";
      }
      if ($accessLevel == 1) { // management
        echo "<a href='./monthly_report.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Monthly Report</a>";
      }
    ?>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large text-primary w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button text-primary w3-margin-right" onclick="w3_open()">☰</a>
  <span>Haywoods</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px">
    <h1 class="w3-jumbo"><b>Monthly Report</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>Select Month.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container border border-dark bg-primary text-white dropshadow p-2 mb-2">
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
            echo "<td>£$cashSales</td>";
            echo "<td>£$cardSales</td>";
            echo "<th>£$totalSales</th>";
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
            echo "<td>".$topSeller[0]."</td>";
            echo "<td>".$topSeller[1]."</td>";
            echo "<td>".$topSeller[2]."</td>";
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
          <td>520</td>
          <td>£4732.00</td>
        </tr>
      </table>
    </div>
  </div>

<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
