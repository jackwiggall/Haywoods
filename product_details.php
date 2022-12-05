<?php
require "database.php";


if (!isset($_GET['sku'])) {
  die("invalid sku, TODO pretty");
}
$product_sku = $_GET['sku'];

/*** Get product name,description and price ***/
// get product sku code from url http://localhost/product_details.php?sku=XXXXXX
// and escape it to prevent naughty sql injection attacks

// query view ProductWithRating to get the average rating of a product along with other details
$stmt = $conn->prepare("SELECT name,description,price,rating, storeLocation, stockLevel FROM vProductDetails WHERE sku_code = :sku");
$stmt->bindParam("sku", $product_sku);
$stmt->execute();

$productDetails = $stmt->fetchAll(); // read sql response from query

// the $item_row variable is an array of name,description,price
// extract values from array and put them in seperate varaibles to be inlined
// with the html code below
$product_name = $productDetails[0]['name'];
$product_description = $productDetails[0]['description'];
$product_price = $productDetails[0]['price'];
$average_rating = $productDetails[0]['rating'];


$stmt = $conn->prepare("SELECT rating,title,content,review_date FROM Review WHERE Review.sku_code = :sku ORDER BY review_date ASC");
$stmt->bindParam("sku", $product_sku);
$stmt->execute();
$reviews = $stmt->fetchAll(); // get all reviews

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $product_name; ?> | Haywoods</title>
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
    <a href="./product_search.php">Return to product search</a>
    <h1 class="w3-jumbo"><b><?php echo $product_name; ?></b></h1> <!--Page Title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container border border-dark bg-primary p-2 mt-2 dropshadow">
      <div class="row p-2">
        <div class="col"> <!--Image-->
          <img src="<?php echo "./images/${product_sku}.jpg"; ?>" class="card-img-top border border-dark" alt="...">
        </div>
        <div class="col"> <!--Information-->
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Product Code: <?php echo $product_sku; ?></div>
          <br>
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Price: £<?php echo $product_price; ?></div>
          <br>
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Rating: <?php echo $average_rating; ?>/10 Stars</div><br>
          
          <select class="d-inline-block p-2 mt-2">
          <?php
            foreach ($productDetails as $productDetail) {
              $stockLevel = $productDetail['stockLevel'];
              $storeLocation = $productDetail['storeLocation'];
              echo "<option>Store: $storeLocation, In stock: $stockLevel</option>";
            }
          ?>
          </select>

          <h4 class="pt-3 mb-3 text-white">Description</h4>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light"><?php echo $product_description; ?></div>
          </div>
          <?php
            if (empty($reviews)) {
              echo '<h3 class="p-3 m-2 mb-0 pb-0 text-white">No Product Reviews yet...</h3>';
            } else {
              echo '<h3 class="p-3 m-2 mb-0 pb-0 text-white">Product Reviews</h3>';
            }
            foreach ($reviews as $review) {
              $review_rating = $review['rating'];
              $review_title = $review['title'];
              $review_content = $review['content'];
              $review_date = $review['review_date'];
              if ($review_title != '') { // only show reviews which have a title
                echo '<div class="d-inline-block p-3 mt-3 border border-dark bg-light">';
                echo '<b>'.$review_title.'</b>';
                echo '<b class="f-r"> '.$review_rating.'/10 Stars</b>';
                echo '<p>'.$review_content.'</p>';
                echo '</div>';
              }
            }
          ?>

      </div>
    </div>
  </div>

<!-- End page content -->
</div>


</body>
</html>
