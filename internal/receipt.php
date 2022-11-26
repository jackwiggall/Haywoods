<?php

require 'access_level.php';
requireAccessLevel(4);


if (!isset($_GET["sale"])) {
  die("sale not set");
}

$sale_id = $_GET["sale"];

$receiptDetailsQuery = "SELECT Store.location, Staff.firstname, Sale.date, Sale.totalCost, Sale.review_code
                        FROM Sale, Store, Staff
                        WHERE Store.store_id = Sale.store_id
                        AND Staff.staff_id = Sale.staff_id
                        AND Sale.sale_id = :sale_id";

$stmt = $conn->prepare($receiptDetailsQuery);
$stmt->bindParam("sale_id", $sale_id);
$stmt->execute();

$row = $stmt->fetch();
if ($row == null) {
  die("reciept not found");
}
$sale_store_location = $row[0];
$sale_staff_name = $row[1];
$sale_date_time = explode(" ", $row[2]);
$sale_totalCost = $row[3];
$sale_reviewCode = $row[4];




// get products
$stmt = $conn->prepare("SELECT Product.sku_code, Product.name, Product.price FROM Product WHERE Product.sku_code in (SELECT sku_code FROM Sale_Product WHERE sale_id = :sale_id)");
$stmt->bindParam("sale_id", $sale_id);
$stmt->execute();

$sale_items = $stmt->fetchAll();

$sale_items_count = count($sale_items);


$stmt = $conn->prepare("SELECT last4Digits FROM CardPayment WHERE sale_id = :sale_id");
$stmt->bindParam("sale_id", $sale_id);
$stmt->execute();

$row = $stmt->fetch();
if ($row != null) { // card payment
  $sale_card_last4Digits = $row[0];
  var_dump($row);
} else { // cash payment
  $stmt = $conn->prepare("SELECT initialTender FROM CashPayment WHERE sale_id = :sale_id");
  $stmt->bindParam("sale_id", $sale_id);
  $stmt->execute();

  $row = $stmt->fetch();
  $sale_initialTender = $row[0];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css">
  <title>Receipt</title>
</head>
<body>
  <div class="d-flex justify-content-center flex-nowrap mt-4">
    <div class="bg-white p-3 border border-dark" style="width: 500px;">
      <h1 class="text-center">Haywoods</h1>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <div>
          <span>Store Location: </span><strong><?php echo $sale_store_location; ?></strong>
        </div>
        <div>
          <span>Staff: </span><strong><?php echo $sale_staff_name; ?></strong>
        </div>
        <div class="row text-center">
          <div class="col"><?php echo $sale_date_time[0]; ?></div>
          <div class="col"><?php echo $sale_date_time[1]; ?></div>
          <div class="col"><?php echo $sale_id; ?></div>
        </div>
      </div>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <?php
          foreach ($sale_items as $sale_item) {
            echo "<div>";
            echo "<div>".$sale_item[1]."</div>";
            echo '<div class="row">';
            echo '<div class="col">';
            echo '<span>'.$sale_item[0]."</span><span> x 1</span>";
            echo "</div>";
            echo '<div class="col text-end">';
            echo '<span>@ £</span><span>'.$sale_item[2]."</span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
        ?>
      </div>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <div class="row">
          <div class="col">
            <span>SALE Total</span>
          </div>
          <div class="col text-end">
            <strong><span> £</span><span><?php echo $sale_totalCost; ?></span></strong>
          </div>
        </div>
      </div>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <?php
          if (isset($sale_card_last4Digits)) {
            echo "<span>Card Number: **** **** **** $sale_card_last4Digits</span>";
          } else {
            echo "<div><span>Initial Tender: £".$sale_initialTender."</span></div>";
            echo "<div><span>Change: £".$sale_initialTender - $sale_totalCost."</span></div>";
          }
        ?>
      </div>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <span>Total No of Items: <?php echo $sale_items_count; ?></span>
      </div>

      <div class="border-2 border-top border-bottom border-dark mt-1">
        <div>
          Happy or unhappy with your purchase? please write a product
          review on our website with the code below.
        </div>
        <div class="text-center">
          <strong style='font-family: monospace'><?php echo $sale_reviewCode; ?></strong>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

