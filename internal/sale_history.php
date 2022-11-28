<?php

require "../database.php";

require "access_level.php";
requireAccessLevel(2);

// flag to hide table headers if no query executed
$queryExecuted = false;
$sales = [];
if (isset($_GET['date']) || isset($_GET['store'])) {
  $queryExecuted = true;
  $query_where = "WHERE";

  if (isset($_GET['date'])) {
    $query_where = "$query_where cast(date as date) = cast(:date as date) AND";
  }
  if (isset($_GET['store'])) {
    $query_where = "$query_where store_id = :store AND";
  }


  if ($query_where == "WHERE") { // no where clauses added
    $query_where = "";
  } else {
    $query_where = substr($query_where, 0, -4); // remove trailing AND
  }
  $stmt = $conn->prepare("SELECT sale_id,CAST(date as date),CAST(date as time),firstname,lastname,quantity,totalCost FROM SaleHistory $query_where");
  if (isset($_GET['date']))  $stmt->bindParam("date", $_GET['date']);
  if (isset($_GET['store'])) $stmt->bindParam("store", $_GET['store']);

  $stmt->execute();

  $sales = $stmt->fetchAll();
}

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
    <h1 class="w3-jumbo"><b>Sale History</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>Details.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container border border-dark bg-primary dropshadow p-2">
      <form action="" method="GET">
        <!-- store location-->
        <p class="d-inline-block border border-dark bg-light p-2">Store Location: </p>
        <select name="store">
          <?php
            $stmt = $conn->prepare("SELECT store_id, location FROM Store");
            $stmt->execute();
            while (($store = $stmt->fetch()) != null) {
              echo '<option value="'.$store[0].'">'.$store[1].'</option>';
            }
          ?>
        </select>
        <br>

        <p class="d-inline-block border border-dark bg-light p-2">Sale Date: </p>
        <input type="date" class="bg-light p-2" name="date"
        <?php
          if (isset($_GET["date"])) {
            echo "value=".$_GET["date"];
          } else {
            $currentDate = date("Y-m-d");
            echo "value=".$currentDate;
          }
        ?>
        ><br>

        <!-- <p class="d-inline-block border border-dark bg-light p-2">Total Value:</p> <input type="number"
          class="bg-light p-2" name="sku" placeholder="0"><br>
        <p class="d-inline-block border border-dark bg-light p-2">SKU:</p> <input type="text" class="bg-light p-2"
          name="sku" placeholder="000000"><br> -->
        <input type="submit" value="Search" class="btn btn-dark mt-1 border border-primary w300">
      </form>
    </div>

    <?php
      if (!$queryExecuted) {
        die("</div></body></html>");
      }
    ?>
    <!--hide below until search-->
    <div class="container border border-dark bg-primary dropshadow p-2 mt-4">
      <table class="table table-bordered border-dark bg-light">
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Cashier</th>
          <th>Item Quantity</th>
          <th>Value</th>
          <th>More Details</th>
        </tr>
        <?php
          foreach ($sales as $sale) {
            // sale_id,CAST(date as date),CAST(date as time),firstname,lastname,quantity,totalCost
            echo "<tr>";
            echo "<td>".$sale[1]."</td>";
            echo "<td>".$sale[2]."</td>";
            echo "<td>".$sale[3]." ".$sale[4]."</td>";
            echo "<td>".$sale[5]."</td>";
            echo "<td>".$sale[6]."</td>";
            echo '<td><a href="./receipt.php?sale='.$sale[0].'">View Receipt</a></td>';
            echo "</tr>";
          }
        ?>
      </table>
    </div>
  </div>

<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

</body>
</html>
