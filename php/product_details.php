<?php
// database login details
$dbhost = "127.0.0.1"; // change to silvia.computing.dundee.ac.uk
$dbuser = "22ac3u03";
$dbpass = "ac31b2";
$dbname = "22ac3d03";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// connection failed
if ($conn->connect_error) {
  // dont render html page, just display error message
  die("database error");
  // no code after here is executed
}


/*** Get product name,description and price ***/
// get product sku code from url http://localhost/product_details.php?sku=XXXXXX
// and escape it to prevent naughty sql injection attacks
$product_sku = $conn->real_escape_string($_GET['sku']);
try {
  $res = $conn -> query("SELECT name,description,price FROM Product WHERE sku_code = $product_sku");
} catch (mysqli_sql_exception $e) {
  // query failed, item not found
  die("product not found return to homepage TODO");
}
$item_row = $res->fetch_row(); // read sql response from query
// the $item_row variable is an array of name,description,price
// extract values from array and put them in seperate varaibles to be inlined
// with the html code below
$product_name = $item_row[0];
$product_description = $item_row[1];
$product_price = $item_row[2];

/*** Get product reviews ***/
// get average rating
$res = $conn -> query("SELECT AVG(rating) AS AverageRating FROM Review WHERE Review.sku_code = $product_sku");
$average_rating = $res->fetch_row()[0];

$res = $conn -> query("SELECT rating,title,content,review_date FROM Review WHERE Review.sku_code = $product_sku ORDER BY review_date ASC");
$reviews = $res->fetch_all(); // get all reviews

?>


<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Product Details</title>
    <link rel="stylesheet" href="./styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Product Details</h1>

      <div class="container border border-dark bg-info p-2 mt-2">
        <div class="row p-2">
          <div class="col"> <!--Image-->
            <img src="blank.png" class="card-img-top border border-dark" alt="...">
          </div>
          <div class="col"> <!--Information-->
            <h3 class="p-3 mb-3 border border-dark bg-light"> <?php echo $product_name; ?></h3>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Product Code: <?php echo $product_sku; ?></div>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">£<?php echo $product_price; ?></div>
            <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Rating: <?php if (isset($average_rating)) echo round($average_rating, 1); else echo '?'; ?>/10 Stars</div><br>
              <!--form?-->
              <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Enter your postcode: </div>
                <input type="text" class="bg-light p-2 mt-2" name="postcode" placeholder="DD1 2LN"><br>
              <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Nearest Store: </div>
                <input type="text" class="bg-light p-2 mt-2" name="store" placeholder="DD2 5FP"><br>
              <div class="d-inline-block p-2 mt-2 border border-dark bg-light">Stock Level </div>
                <input type="text" class="bg-light p-2 mt-2" name="stock" placeholder="21"><br>

            <h4 class="pt-3 mb-3">Description</h4>
              <div class="d-inline-block p-2 mt-2 border border-dark bg-light"><?php echo $product_description; ?></div>
            </div>
            <h3 class="p-3 m-2">Product Reviews</h3>
            <?php
              foreach ($reviews as $review) {
                $review_rating = $review[0];
                $review_title = $review[1];
                $review_content = $review[2];
                $review_date = $review[3];
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
  </body>

</html>
