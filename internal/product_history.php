<?php

require './access_level.php';
requireAccessLevel(3);

require '../database.php';

$results = null;
$notFoundError = false;
if (isset($_GET['sku']) && !empty($_GET['sku'])) {
  $stmt = $conn->prepare("SELECT date, quantitySold, priceChange FROM ProductHistory WHERE sku_code = :sku_code AND (store_id = :store_id OR store_id IS NULL)");
  $stmt->bindParam("store_id", $_SESSION['store_id']);
  $stmt->bindParam("sku_code", $_GET['sku']);
  $stmt->execute();
  $results = $stmt->fetchAll();

  $stmt = $conn->prepare("SELECT count FROM vStockLevel WHERE store_id = :store_id AND sku_code = :sku_code");
  $stmt->bindParam("store_id", $_SESSION['store_id']);
  $stmt->bindParam("sku_code", $_GET['sku']);
  $stmt->execute();
  $row = $stmt->fetch();
  if ($row == null) {
    $results = null;
    $notFoundError = true;
  } else {
    $stockLevel = $row[0];
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
    <h1 class="w3-jumbo"><b>Product History</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>SKU Code.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container bg-primary border border-dark p-2 dropshadow">
      <form action="?" method="get">
        <p class="d-inline-block border border-dark bg-light p-2">Product SKU:</p> <input type="text"
          class="bg-light p-2" name="sku" placeholder="000000" value=<?php if (isset($_GET['sku'])) { echo $_GET['sku']; }?>><br>
        <input type="submit" value="Search" class="btn btn-dark mt-1 border border-dark w300">
      </form>
    </div>
  </div>

  <?php
    if ($results == null) {
      if ($notFoundError) {
        echo "not found";
      }
      die("</div></body></html>");
    }
  ?>

  <!--History-->
  <div class='w3-container' style='margin-top:80px'>
    <hr style='width:50px;border:5px solid blue' class='w3-round'>
    <?php
      echo "<h2>Current Stock: $stockLevel</h2>";
    ?>
    <div class='container bg-primary border border-dark p-2 dropshadow'>
      <table class='table table-bordered border-dark bg-light'>
        <tr>
          <!-- <th>Date</th>
          <th>Time</th>
          <th>Start Price</th>
          <th>End Price</th>
          <th>Start Stock</th>
          <th>End Stock</th> -->

          <th>Date</th>
          <th>Time</th>
          <th>Description</th>
          <th>Price</th>
          <th>Sold</th>
        </tr>
        <?php
          if ($results != null) {
            foreach ($results as $result) {
              $timeDate = explode(" ", $result['date']);
              echo "<tr>";
              echo "<td>".$timeDate[0]."</td>";
              echo "<td>".$timeDate[1]."</td>";
              if ($result['priceChange']) {
                echo "<td>Price Change</td>";
                echo "<td>£".$result['priceChange']."</td>";
                echo "<td>N/A</td>";
              } else {
                echo "<td>Sale</td>";
                echo "<td>N/A</td>";
                echo "<td>".$result['quantitySold']."</td>";
              }
              
              // echo "<td>".$result[]."</td>";
              // echo "<td>".$result[]."</td>";
              // echo "<td>".$result[]."</td>";
            }
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
