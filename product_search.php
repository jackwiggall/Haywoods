<?php

require './database.php';

$results = [];
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  // set max and min variables for sql query based on form input,
  $min = 0; // if minimum price not set default to 0
  $max = PHP_INT_MAX; // if maximum price not set default to a very large number
  if (!empty($_GET['min']))
    $min = (int) $_GET['min'];
  if (!empty($_GET['max']))
    $max = (int) $_GET['max'];

  // make order by queried based on form
  $orderBy = "";
  if (isset($_GET['order'])) {
    switch ($_GET['order']) {
      case 'rating':
        $orderBy = "ORDER BY (CASE WHEN rating = '?' THEN 1 ELSE 0 END), rating DESC";
        break;
      case 'price_low':
        $orderBy = "ORDER BY price ASC";
        break;
      case 'price_high':
        $orderBy = "ORDER BY price DESC";
        break;
    }
  }

  // sql query
  $stmt = $conn->prepare("SELECT sku_code, name, price, rating
                          FROM vProductDetails
                          WHERE name LIKE :search
                          OR sku_code = :sku_code
                          AND :minimum < price AND :maximum > price
                          GROUP BY sku_code $orderBy");
  $wildcardSearch = "%$search%"; // wildcard search to match any products with $search in their name
  $stmt->bindParam("search", $wildcardSearch);
  // also find product with the same sku code as search for if a user searches a sku code directly
  $stmt->bindParam("sku_code", $search);
  $stmt->bindParam("minimum", $min);
  $stmt->bindParam("maximum", $max);

  $stmt->execute();

  // save sql result to variable to be used in the code below
  $results = $stmt->fetchAll();

  // user searched a valid sku code, immediately redirect to page
  if (strlen($search) == 6 && is_numeric($search) && count($results) == 1) {
    header("location: ./product_details.php?sku=$search");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Product Search | Haywoods</title>
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
        <h1 class="w3-jumbo"><b>Product Search</b></h1>
        <!--Page Title-->
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <!--Search input-->
        <form action="" method="GET" class="border border-dark bg-primary p-2 mt-2 dropshadow">
          <div class="btn-toolbar mb-3" role="toolbar">
            <div class="input-group m-r mt-2 pr-5">
              <input type="text" name="search" class="form-control bg-light" placeholder="product keyword" value="<?php if (isset($_GET["search"])) {
                echo $_GET["search"];
              } ?>">
              <div class="input-group-prepend">
                <input type="submit" class="input-group-text bg-dark text-white" id="btnGroupAddon" value="Search">
              </div>
            </div>
            <!--Minimum input-->
            <div class="input-group m-r mt-2 pr-5">
              <div class="input-group-prepend">
                <div class="input-group-text bg-dark text-white" id="btnGroupAddon">Min Price</div>
              </div>
              <input type="text" name="min" class="form-control bg-light" style="width: 60px;" placeholder="£" value="<?php if (isset($_GET["min"])) {
                echo $_GET["min"];
              } ?>">
            </div>
            <!--Maxium input-->
            <div class="input-group m-r mt-2 pr-5">
              <div class="input-group-prepend">
                <div class="input-group-text bg-dark text-white" id="btnGroupAddon">Max Price</div>
              </div>
              <input type="text" name="max" class="form-control bg-light" style="width: 60px;" placeholder="£" value="<?php if (isset($_GET["max"])) {
                echo $_GET["max"];
              } ?>">
            </div>
            <!--Order-->
            <div class="input-group m-r mt-2 pr-5">
              <div class="input-group-prepend">
                <div class="input-group-text bg-dark text-white" id="btnGroupAddon">Order By</div>
              </div>
              <select name="order">
                <?php
                // create drop down options while also preserving last selected value as it gets reset on browser refresh
                $values = ["revelance", "rating", "price_low", "price_high"];
                $names = ["Revelance", "Star Rating", "Price (lowest first)", "Price (highest first)"];

                foreach ($values as $i => $value) {
                  $selected = "";
                  if (isset($_GET['order']) && $_GET['order'] == $value) {
                    $selected = "selected";
                  }
                  echo '<option value="' . $value . '"' . $selected . '>' . $names[$i] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <?php
      if (empty($results) && isset($_GET['search'])) {
        echo '<div class="w3-round container mt-4 p-2 bg-warning">no items found matching keyword</div>';
        die("</div></body></html>");
      }
      ?>
      <!-- Output, if empty hide -->
      <div class="w3-container mt-4">
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <div class="row">
          <?php
          foreach ($results as $result) {
            // sku_code, name, price
            echo '<div class="card bg-primary m-2 d-inline-block" style="width: 250px;">';
            echo '<a href="./product_details.php?sku=' . $result['sku_code'] . '">';
            echo '<div class="bg-white text-center card-img-top mt-2 border border-dark">';
            echo '<img class="img-fluid" style="height: 250px;" src="images/' . $result['sku_code'] . '.jpg">';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<p class="card-title text-light pl-1" style="height: 60px;">' . $result['name'] . '</p>';
            echo '<p class="card-text text-end text-light pl-1">£' . $result['price'] . '</p>';
            $ratingText = $result['rating'] == '?' ? 'No rating' : $result['rating'] . '/10 Stars';
            echo '<p class="card-footer mb-auto text-light pl-1">' . $ratingText . '</p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
          }
          ?>
        </div>
      </div>

      <!-- End page content -->
    </div>

  </body>

</html>