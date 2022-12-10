<?php

require '../database.php';

require 'access_level.php';
requireAccessLevel(4);


if (!isset($_GET["sale"])) {
  die("sale not set");
}

$sale_id = $_GET["sale"];


// query ReceiptDetails View
$stmt = $conn->prepare("SELECT date, totalCost, review_code, location, firstname, initialTender, last4Digits FROM vReceiptDetails WHERE sale_id = :sale_id");
$stmt->bindParam("sale_id", $sale_id);
$stmt->execute();
$row = $stmt->fetch();
if ($row == null) {
  die("receipt not found");
}
$sale_date_time = explode(" ", $row['date']);
$sale_totalCost = $row['totalCost'];
$sale_reviewCode = $row['review_code'];
$sale_store_location = $row['location'];
$sale_staff_name = $row['firstname'];
$sale_initialTender = $row['initialTender'];
$sale_card_last4Digits = $row['last4Digits'];


// get products
$stmt = $conn->prepare("SELECT sku_code, name, price, quantity FROM vSaleItems WHERE sale_id = :sale_id");
$stmt->bindParam("sale_id", $sale_id);
$stmt->execute();

$sale_items = $stmt->fetchAll();

$sale_items_count = count($sale_items);


$protocol = "http://";
if (isset($_SERVER['HTTPS']))
  $protocol = "https://";
$reviewUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['PHP_SELF'])) . "/review.php";
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
            echo "<div>" . $sale_item['name'] . "</div>";
            echo '<div class="row">';
            echo '<div class="col">';
            echo '<span>' . $sale_item['sku_code'] . "</span><span> x 1</span>";
            echo "</div>";
            echo '<div class="col text-end">';
            echo '<span>@ £</span><span>' . $sale_item['price'] . "</span>";
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
            echo "<div><span>Initial Tender: £" . $sale_initialTender . "</span></div>";
            $change = $sale_initialTender - $sale_totalCost;
            echo "<div><span>Change: £$change</span></div>";
          }
          ?>
        </div>

        <div class="border-2 border-top border-bottom border-dark mt-1">
          <span>Total No of Items: <?php echo $sale_items_count; ?></span>
        </div>

        <div class="border-2 border-top border-bottom border-dark mt-1">
          <div>
            Happy or unhappy with your purchase? Please write a product
            review on our <?php echo "<a href='${reviewUrl}?review_code=$sale_reviewCode'>website</a> ($reviewUrl)"; ?>
            with the code below.
          </div>
          <div class="text-center">
            <strong style='font-family: monospace'><?php echo $sale_reviewCode; ?></strong>
          </div>
        </div>
      </div>
    </div>
  </body>

</html>