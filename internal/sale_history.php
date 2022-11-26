<?php

require "access_level.php";
requireAccessLevel(2);

$items = array();
if (isset($_POST['date']) || isset($_POST['store'])) {
  $query_where = "WHERE";

  if (isset($_POST['date'])) {
    $query_where += " cast(date as date) = cast(:date as date) AND";
  }
  if (isset($_POST['store'])) {
    $query_where += " store_id = :store AND";
  }


  if ($query_where == "WHERE") { // no where clauses added
    $query_where = "";
  } else {
    $query_where = substr($query_where, 0, -4); // remove trailing AND
  }

  $stmt = $conn->prepare("SELECT sale_id,date,staff_id,totalCost FROM Sale "+$query_where);
  if (isset($_POST['date']))  $stmt->bindParam("date", $_POST['date']);
  if (isset($_POST['store'])) $stmt->bindParam("store", $_POST['store']);

  $stmt->execute();

  while (($store = $stmt->fetch()) != null) {

  }
  // SELECT COUNT(quantity) AS quantity FROM Sale_Product WHERE sale_id = (SELECT sale_id FROM Sale $query_where)



  // $items = $stmt->fetchAll();
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
              echo '<option value="'.$store[0].'">'.$store[1].'</option>';
            }
          ?>
        </select>
        <br>

        <p class="d-inline-block border border-dark bg-light p-2">Sale Date: </p>
        <input type="date" class="bg-light p-2" name="date" <?php if (isset($_POST["date"])) { echo "value=".$_POST["date"]; } ?>><br>

        <!-- <p class="d-inline-block border border-dark bg-light p-2">Total Value:</p> <input type="number"
          class="bg-light p-2" name="sku" placeholder="0"><br>
        <p class="d-inline-block border border-dark bg-light p-2">SKU:</p> <input type="text" class="bg-light p-2"
          name="sku" placeholder="000000"><br> -->
        <input type="submit" value="Search" class="btn btn-primary mt-1 border border-dark w300">
      </form>
    </div>

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
        <tr>
          <!--RESPONSIVE OVERFLOW ISSUE-->
          <td>23/01/22</td>
          <td>12:00:00</td>
          <td>John Doe</td>
          <td>3</td>
          <td>£30.99</td>
          <td><a href="#">Click for Sale Details</a></td>
        </tr>
      </table>
    </div>

  </div>
</body>

</html>