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
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <title>Sale History</title>
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <?php require 'login_banner.php'; ?>
  <div class="container">
    <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Sale History</h1>

    <div class="container border border-dark bg-info p-2">
      <form action="" method="GET">
        <!-- store location-->
        <p class="d-inline-block border border-dark bg-light p-2">Store Location: </p>
        <select name="store">
          <?php
            $stmt = $conn->prepare("SELECT store_id, location FROM Store");
            $stmt->execute();
            while (($store = $stmt->fetch()) != null) {
              $selected = "";
              if (isset($_GET["store"])) {
                if ($_GET["store"] == $store['store_id']) {
                  $selected = "selected";
                }
              } elseif ($store['store_id'] == $_SESSION['store_id']) {
                $selected = "selected";
              }

              echo '<option value="'.$store['store_id'].'"'.$selected.'>'.$store['location'].'</option>';
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
        <input type="submit" value="Search" class="btn btn-primary mt-1 border border-dark w300">
      </form>
    </div>

    <?php
      if (!$queryExecuted) {
        die("</div></body></html>");
      }
    ?>
    <!--hide below until search-->
    <div class="container border border-dark bg-info p-2 mt-4">
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
</body>

</html>