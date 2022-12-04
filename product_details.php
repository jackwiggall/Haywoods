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
$stmt = $conn->prepare("SELECT name,description,price, rating FROM vProductDetails WHERE sku_code = :sku");
$stmt->bindParam("sku", $product_sku);
$stmt->execute();

$item_row = $stmt->fetch(); // read sql response from query
// the $item_row variable is an array of name,description,price
// extract values from array and put them in seperate varaibles to be inlined
// with the html code below
$product_name = $item_row['name'];
$product_description = $item_row['description'];
$product_price = $item_row['price'];
$average_rating = $item_row['rating'];


$stmt = $conn->prepare("SELECT rating,title,content,review_date FROM Review WHERE Review.sku_code = :sku ORDER BY review_date ASC");
$stmt->bindParam("sku", $product_sku);
$stmt->execute();
$reviews = $stmt->fetchAll(); // get all reviews

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
    <h1 class="w3-jumbo"><b>Product Details</b></h1> <!--Page Title-->
    <?php echo "<h1 class='w3-xxxlarge text-primary'><b>${product_name}.</b></h1>"; ?><!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container border border-dark bg-primary p-2 mt-2 dropshadow">
      <div class="row p-2">
        <div class="col"> <!--Image-->
          <img src="<?php echo "./images/${product_sku}.jpg"; ?>" class="card-img-top border border-dark" alt="...">
        </div>
        <div class="col"> <!--Information-->
          <h3 class="p-3 mb-3 border border-dark bg-light"> <?php echo $product_name; ?></h3>
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Product Code: <?php echo $product_sku; ?></div>
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">£<?php echo $product_price; ?></div>
          <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Rating: <?php echo $average_rating; ?>/10 Stars</div><br>
            <!--form?-->
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Enter your postcode: </div>
              <input type="text" name="postcode" class="bg-light p-2 mt-2" placeholder="DD1 2LN">
              <input type="submit" class="bg-dark text-white p-2 mt-2" value="Go"><br>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Nearest Store: </div>
              <input type="text" disabled class="bg-light p-2 mt-2" name="store" placeholder="DD2 5FP"><br> <!--change to nearest store-->
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Stock Level </div>
              <input type="text" disabled class="bg-light p-2 mt-2" name="stock" placeholder="21"><br> <!--change to store's stock level-->

          <h4 class="pt-3 mb-3 text-white">Description</h4>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light"><?php echo $product_description; ?></div>
          </div>
          <h3 class="p-3 m-2 text-white">Product Reviews</h3>
          <?php
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

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
