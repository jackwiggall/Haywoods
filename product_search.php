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
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Product Search</title>
    <link rel="stylesheet" href="./styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Product Search</h1>
      <div class="bg-info border border-dark mt-3 mb-3 p-2">
        <h3 class="pt-3">Search</h3>

        <!--Search input-->
        <form action="" method="GET">
          <div class="btn-toolbar mb-3" role="toolbar">
            <div class="input-group m-r mt-2 pr-5">
              <input type="text" name="search" class="form-control bg-light" placeholder="Search" value="<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>">
              <div class="input-group-prepend">
                <input type="submit" class="input-group-text bg-primary text-white" id="btnGroupAddon" value="Search">
              </div>
              </div>
          <!--Minimum input-->
            <div class="input-group m-r mt-2 pr-5">
              <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white" id="btnGroupAddon">£</div>
              </div>
              <input type="text" name="min" class="form-control bg-light" placeholder="Min" value="<?php if (isset($_GET["min"])) echo $_GET["min"]; ?>">
            </div>
            <!--Maxium input-->
            <div class="input-group mt-2">
              <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white" id="btnGroupAddon">£</div>
              </div>
              <input type="text" name="max" class="form-control bg-light" placeholder="Max" value="<?php if (isset($_GET["max"])) echo $_GET["max"]; ?>">
            </div>
          </div>
        </form>
      </div>

      <div class="card-deck">
        <?php
          foreach ($results as $result) {
            // sku_code, name, price
            echo '<div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">';
            echo '<a href="./product_details.php?sku='.$result[0].'"><img src="images/'.$result[0].'_0.jpg" class="card-img-top border border-dark" alt="...">';
            echo '<div class="card-body">';
            echo '<p class="card-text text-white bg-primary pl-1 border border-dark">'.$result[2].'</p>';
            echo '<p class="card-text text-white bg-primary pl-1 border border-dark d-block">'.$result[1].'</p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';

          }
        ?>
        <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
          <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--1 of 8-->
            <div class="card-body">
              <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
              <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
            </div>
          </a>
        </div>
        <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
          <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--2 of 8-->
            <div class="card-body">
              <p class="card-text text-white bg-primary pl-1 border border-dark">£39.00</p>
              <p class="card-text text-white bg-primary pl-1 border border-dark d-block">Bedside Cabinet</p>
            </div>
          </a>
        </div>
        <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
          <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--3 of 8-->
            <div class="card-body">
              <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
              <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
            </div>
          </a>
        </div>
        <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
          <a href="#"><img src="blank.png" class="card-img-top" alt="..."> <!--4 of 8-->
            <div class="card-body">
              <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
              <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </body>

</html>
