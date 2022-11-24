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
                    echo "<th>".$scannedItem->{"price"}."</th>";
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
  </body>

</html>
