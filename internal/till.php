<?php
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
    $_SESSION["scanned_items"] = [];
  }
  $scannedItems = $_SESSION["scanned_items"];

  // get product info from db
  $stmt = $conn->prepare("SELECT sku_code,name,price FROM Product WHERE sku_code = :sku");
  $stmt->bindParam("sku", $scanned_sku);
  $stmt->execute();

  $row = $stmt->fetch();

  if ($row == null) {
    $invalidScan = true;
  } else {
    // add to array
    $scannedItems[] = $row;

    // update session cookie
    $_SESSION["scanned_items"] = $scannedItems;
  }
}
if (isset($_POST["reset"])) {
  $_SESSION["scanned_items"] = [];
}

if (isset($_POST["pay-cash"]) || isset($_POST["pay-card"])) {
  $totalCost = 0;
  $sku_codes = array();
  foreach ($_SESSION["scanned_items"] as $scannedItem) {
    $totalCost += $scannedItem["price"];
    $sku_codes[] = $scannedItem["sku_code"];
  }

  // not an empty transaction
  if (!empty($sku_codes)) {   
    // insert into Sale
    $staff_id = $_SESSION['staff_id'];
    $store_id = $_SESSION['store_id'];
    $review_code = dechex(rand(0,pow(2,26)));
    $stmt = $conn->prepare("INSERT INTO Sale (store_id, totalCost, staff_id, review_code) VALUES (:store_id, :totalCost, :staff_id, :review_code)");
    $stmt->bindParam("store_id", $store_id);
    $stmt->bindParam("totalCost", $totalCost);
    $stmt->bindParam("staff_id", $staff_id);
    $stmt->bindParam("review_code", $review_code); // review code to random hex string
    $stmt->execute();

    // get last inserted id to insert into joining tables
    $sale_id = $conn->lastInsertId();

    try {
      // begin transaction
      $conn->beginTransaction();
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
        $cardNumber = $_POST['last4Digits'];
        $stmt->bindParam("last4Digits", $cardNumber);
        $stmt->bindParam("sale_id", $sale_id);
        $stmt->execute();
      } else {
        $stmt = $conn->prepare("INSERT INTO CashPayment (sale_id, initialTender) VALUES (:sale_id, :initialTender)");
        $initialTender = (int)$_POST['initial-tender'];
        $stmt->bindParam("initialTender", $initialTender);
        $stmt->bindParam("sale_id", $sale_id);
        $stmt->execute();
      }
      $conn->commit();
    } catch (Exception $e) {
      $stmt->rollback();
      die("database error");
    }

    // reset scanned items
    $_SESSION["scanned_items"] = [];
  }
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
    <h1 class="w3-jumbo"><b>Till</b></h1> <!--Page Title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="row p-2 bg-primary dropshadow">
      <div class="col-lg-8 col-md-12"> <!--Table-->
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
                echo "<tr>";
                echo "<th>".$scannedItem["sku_code"]."</th>";
                echo "<th>".$scannedItem["name"]."</th>";
                echo "<th>£".$scannedItem["price"]."</th>";
                echo "</tr>";
                $totalPrice += $scannedItem["price"];
              }
            }
          ?>
        </table>
        <form action="" method="POST">
          <input type="number" class="bg-light p-2" name="scanned" placeholder="SKU Code" id="skuCodeInput">
          <input type="submit" value="Scan" class="btn btn-dark p-2 mb-2 border border-light w110">
        </form>
      </div>
    <div class="col float-end"> <!--Buttons-->
    <div class="float-end">
      <h3 class="p-3 border border-dark bg-light w300">Total £<strong id="totalPrice"><?php echo $totalPrice; ?></strong></h3><br>
      
      <form action="" method="POST">
        <?php
          if (!empty($_SESSION['scanned_items'])) {
            echo '<input type="submit" value="Reset transaction" name="reset" class="btn btn-dark mt-1 border border-light w300 center" action=""><br>';
          }
        ?>
      </form>
      <?php
        if (isset($sale_id)) {
          echo "<a href='./receipt.php?sale=$sale_id' target='_blank'><button class='btn btn-dark mt-1 border border-light w300 h100 center'>Print Prior Sale Receipt</button></a>";
        }
      ?>
      <form action="" method="POST" id="payConfirmForm">
      </form>
        <button type="submit" class="btn btn-light mt-1 border border-dark w300 center" id="payCardBtn">Pay Card</button>
        <br>
        <button type="submit" class="btn btn-light mt-1 border border-dark w300 center" id="payCashBtn">Pay Cash</button>
        <br>
        <div id="payCashBox" class="input-group mt-2 text-white hide">
          Enter money given:<br>
          <input type="number" id="initial-tender">
        </div>
        <div id="payCardBox" class="text-white hide">
          Card reader has detected card<br> ending in <strong id="card-last4Digits"><?php echo rand(1000,9999); ?></strong>
        </div>
        <button class="btn btn-success mt-1 border border-dark w300 h100 center hide" id="payConfirmBtn">
          CONFIRM Payment
        </button>
    </div>
    </div>
  </div>
  </div>

<!-- End page content -->
</div>

<script>
// auto focus sku_code input box
document.getElementById("skuCodeInput").focus();


// js to show pay by card / cash buttons
function showCardBox() {
  document.getElementById("payCashBox").style.display = "none";
  document.getElementById("payCardBox").style.display = "block";
  document.getElementById("payConfirmBtn").style.display = "block";
}
function showCashBox() {
  document.getElementById("payCardBox").style.display = "none";
  document.getElementById("payCashBox").style.display = "block";
  document.getElementById("payConfirmBtn").style.display = "block";
}
function haveItemsBeenScanned() {
  return (document.getElementById("totalPrice").textContent !== "0")
}

function createInputElement(key, val) {
  const inputElement = document.createElement("input");
  inputElement.type = "hidden";
  inputElement.name = key;
  inputElement.value = val;
  return inputElement
}

document.getElementById("payConfirmBtn").addEventListener("click", (e) => {
  const payConfirmForm = document.getElementById("payConfirmForm");
  payConfirmForm.innerHTML = ''; // clear
  if (paymentMethod === "pay-card") {
    // get card number
    const last4Digits = document.getElementById("card-last4Digits").textContent;
    payConfirmForm.appendChild(createInputElement("pay-card", "true"));
    payConfirmForm.appendChild(createInputElement("last4Digits", last4Digits));
  } else {
    // get cost values
    const initialTender = document.getElementById("initial-tender").value;
    const totalPrice = Number(document.getElementById("totalPrice").textContent);

    // check enough money is given
    console.log(totalPrice, initialTender);
    if (initialTender < totalPrice) {
      return
    }
    payConfirmForm.appendChild(createInputElement("pay-cash", "true"));
    payConfirmForm.appendChild(createInputElement("initial-tender", initialTender));
  }
  payConfirmForm.submit();
})

let paymentMethod = "";
document.getElementById("payCardBtn").addEventListener("click", (e) => {
  paymentMethod = "pay-card";
  if (haveItemsBeenScanned()) {
    showCardBox();
  }
})

document.getElementById("payCashBtn").addEventListener("click", (e) => {
  paymentMethod = "pay-cash";
  if (haveItemsBeenScanned()) {
    showCashBox();
  }
})
</script>
</body>
</html>
