<?php

require './database.php';

$results = [];
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $min = 0;
  $max = PHP_INT_MAX;
  if (!empty($_GET['min'])) $min = (int)$_GET['min'];
  if (!empty($_GET['max'])) $max = (int)$_GET['max'];



  $stmt = $conn->prepare("SELECT sku_code, name, price
                          FROM ProductList
                          WHERE name LIKE :search
                          AND :minimum < price AND :maximum > price");
  $wildcardSearch = "%$search%";
  $stmt->bindParam("search", $wildcardSearch);
  $stmt->bindParam("minimum", $min);
  $stmt->bindParam("maximum", $max);


  $stmt->execute();
  $results = $stmt->fetchAll();
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
<link rel="stylesheet" href="./styles.css">
</head>
<body>

<!-- Sidebar/menu -->
<?php require './sidebar.php'; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px">
    <h1 class="w3-jumbo"><b>Product Search</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>Search.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <!--Search input-->
    <form action="" method="GET" class="border border-dark bg-primary p-2 mt-2 dropshadow">
      <div class="btn-toolbar mb-3" role="toolbar">
        <div class="input-group m-r mt-2 pr-5">
          <input type="text" name="search" class="form-control bg-light" placeholder="Search" value="<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>">
          <div class="input-group-prepend">
            <input type="submit" class="input-group-text bg-dark text-white" id="btnGroupAddon" value="Search">
          </div>
          </div>
      <!--Minimum input-->
        <div class="input-group m-r mt-2 pr-5">
          <div class="input-group-prepend">
            <div class="input-group-text bg-dark text-white" id="btnGroupAddon">£</div>
          </div>
          <input type="text" name="min" class="form-control bg-light" placeholder="Min" value="<?php if (isset($_GET["min"])) echo $_GET["min"]; ?>">
        </div>
        <!--Maxium input-->
        <div class="input-group mt-2">
          <div class="input-group-prepend">
            <div class="input-group-text bg-dark text-white" id="btnGroupAddon">£</div>
          </div>
          <input type="text" name="max" class="form-control bg-light" placeholder="Max" value="<?php if (isset($_GET["max"])) echo $_GET["max"]; ?>">
        </div>
      </div>
    </form>
  </div>
  <!-- Output, if empty hide -->
  <div class="w3-container" style="margin-top:80px">
    <h1 class="w3-xxxlarge text-primary"><b>Results.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
      <div class="card-deck">
        <?php
          foreach ($results as $result) {
            // sku_code, name, price
            echo '<div class="card bg-primary dropshadow border border-dark p-2 mb-2 m-r d-inline-block c-width">';
            echo '<a href="./product_details.php?sku='.$result[0].'"><img src="images/'.$result[0].'_0.jpg" class="card-img-top border border-dark" alt="...">';
            echo '<div class="card-body">';
            echo '<p class="card-text text-light pl-1">£'.$result[2].'</p>';
            echo '<p class="card-text text-light pl-1 d-block">'.$result[1].'</p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
          }
        ?>
      </div>
    </div>

<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

</body>
</html>
