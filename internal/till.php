<?php
// have items send to self in post request,
// add to cookie
// parse cookie in table

// ensure session is started
if (session_status() == PHP_SESSION_NONE) session_start();

require './access_level.php';
requireAccessLevel(4);

require '../database.php';

$invalidScan = false;
if (isset($_POST["scanned"])) {
  $scanned_sku = $_POST["scanned"];

  // initialize cookie
  if (!isset($_SESSION["scanned_items"])) {
    $_SESSION["scanned_items"] = "[]";
  }
  $scannedItems = json_decode($_SESSION["scanned_items"]);

  // get product info from db
  $stmt = $conn->prepare("SELECT sku_code,name,price FROM Product WHERE sku_code = :sku");
  $stmt->bindParam("sku", $scanned_sku);
  $stmt->execute();

  $row = $stmt->fetch();
  
  if ($row == null) {
    $invalidScan = true;
  } else {
    // add to array
    $scannedItems[] = json_encode($row);
  
    // update cookie
    $_SESSION["scanned_items"] = json_encode($scannedItems);
  }
}
if (isset($_POST["reset"])) {
  $_SESSION["scanned_items"] = "[]";
}

if (isset($_POST["pay-cash"]) || isset($_POST["pay-card"])) {
  $totalCost = 0;
  $sku_codes = array();
  foreach (json_decode($_SESSION["scanned_items"]) as $scannedItem) {
    $scannedItem = json_decode($scannedItem);
    $totalCost += $scannedItem->{"price"};
    $sku_codes[] = $scannedItem->{"sku_code"};
  }

  // not an empty transaction
  if (!empty($sku_codes)) {
    // get staff id by querying using session username
    // put sale through first, get sale_id, then make other tables
    // sotre_id from staff
  
    $stmt = $conn->prepare("SELECT staff_id, store_id FROM Staff WHERE login_username = :username");
    $stmt->bindParam("username", $_SESSION["username"]);
    $stmt->execute();
  
    $row = $stmt->fetch();
    $staff_id = $row[0];
    $store_id = $row[1];
  
  
    // insert into Sale
    $review_code = bin2hex(random_bytes(8));
    $stmt = $conn->prepare("INSERT INTO Sale (store_id, totalCost, staff_id, review_code) VALUES (:store_id, :totalCost, :staff_id, :review_code)");
    $stmt->bindParam("store_id", $store_id);
    $stmt->bindParam("totalCost", $totalCost);
    $stmt->bindParam("staff_id", $staff_id);
    $stmt->bindParam("review_code", $review_code); // review code to random hex string
    $stmt->execute();
  
    $sale_id = $conn->lastInsertId();
  
    // insert into Sale_Product
    foreach ($sku_codes as $sku_code) {
      $stmt = $conn->prepare("INSERT INTO Sale_Product (sale_id, sku_code, quantity) VALUES (:sale_id, :sku_code, 1)");
      $stmt->bindParam("sale_id", $sale_id);
      $stmt->bindParam("sku_code", $sku_code);
      $stmt->execute();
    }
  
    // insert into CardPayment & CashPayment
    if (isset($_POST["pay-card"])) {
      $stmt = $conn->prepare("INSERT INTO CardPayment (sale_id, last4Digits) VALUES (:sale_id, :last4Digits)");
      $stmt->bindParam("sale_id", $sale_id);
      $cardNumber = rand(1000,9999);
      $stmt->bindParam("last4Digits", $cardNumber); // random card number
      $stmt->execute();
    } else {
      $stmt = $conn->prepare("INSERT INTO CashPayment (sale_id, initialTender, change) VALUES (:sale_id, :initialTender, :change)");
      $stmt->bindParam("sale_id", $sale_id);
      // assume payments are made only with 20 pound notes
      // TODO
    }

  
  
    // reset scanned items
    $_SESSION["scanned_items"] = "[]";
  }
}



// todo 
/*
have js to show green button to confirm payment, with cash show input box to enter money given
and make popup box to show change,
if card show input box with text above reading 'connected to card reading device, take balance away from card ending in xxxx'
to simulate it actualy connecting to some device


*/

?>


<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Till</title>
    <link rel="stylesheet" href="../styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Till</h1>

      <div class="container border border-dark bg-info p-2 mb-2">
        <div class="row p-2">
          <div class="col"> <!--Table-->
            <h3 class="p-3 border border-dark bg-light">Scanned Items</h3>
            <table class="table table-bordered border-dark bg-light it-pr">
              <tr>
                <th>SKU Code</th>
                <th>Description</th>
                <th>Price</th>
              </tr>
              <?php
                $totalPrice = 0;
                if (isset($scannedItems)) {
                  foreach ($scannedItems as $scannedItem) {
                    $scannedItem = json_decode($scannedItem);
                    echo "<tr>";
                    echo "<th>".$scannedItem->{"sku_code"}."</th>";
                    echo "<th>".$scannedItem->{"name"}."</th>";
                    echo "<th>£".$scannedItem->{"price"}."</th>";
                    echo "</tr>";
                    $totalPrice += $scannedItem->{"price"};
                  }
                }
              ?>
            </table>
            <form action="" method="POST">
              <input type="number" class="bg-light p-2" name="scanned" placeholder="SKU Code">
              <input type="submit" value="Scan" class="btn btn-primary p-2 border border-dark w110">
            </form>
          </div>
        <div class="col"> <!--Buttons-->
        <div class="f-r">
          <h3 class="p-3 border border-dark bg-light w300">Total £<?php echo $totalPrice; ?></h3><br>
          <form action="" method="POST">
            <input type="submit" value="Reset transaction" name="reset" class="btn btn-warning mt-1 border border-dark w300 center" action="">
          </form>
          <form action="" method="POST">
            <input type="submit" value="Pay Card" name="pay-card" class="btn btn-primary mt-1 border border-dark w300 center" action="">
          </form>
          <form action="" method="post">
            <input type="submit" value="Pay Cash" name="pay-cash" class="btn btn-primary mt-1 border border-dark w300 center" action="">
          </form>
          <!-- <button class="btn btn-success mt-1 border border-dark w300 h100 center" action="">CONFIRM<br/>Received<br/>Money</button> -->
        </div>
        </div>
      </div>
    </div>
  </body>

</html>
