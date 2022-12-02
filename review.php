<?php

require './database.php';

$results = [];
if (isset($_GET['review_code'])) {
  $userSale = $_GET['review_code'];




  $stmt = $conn->prepare("SELECT sku_code, name
                          FROM SaleItems
                          WHERE review_code = :review_code
                          GROUP BY sku_code"
                        );

  $stmt->bindParam("review_code", $userSale);
  
  
  
  $stmt->execute();
  $results = $stmt->fetchAll();
  var_dump($results);
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
<nav class="w3-sidebar bg-primary w3-collapse w3-top w3-large w3-padding text-white" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Haywoods</b></h3>
  </div>
  <div class="w3-bar-block"> <!--Check access level? Add login/logout on bar? may need to change addresses-->
    <a href="index.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> <!--Index-->
    <a href="product_search.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Product Search</a> <!-- -->
    <a href="review.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Write a Review</a> <!-- -->
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large text-primary w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button text-primary w3-margin-right" onclick="w3_open()">☰</a>
  <span>Haywoods</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px">
    <h1 class="w3-jumbo"><b>Review</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>Enter Details.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="bg-primary border border-dark mt-3 mb-3 p-2">
      <!--Search input-->
      <form action="" method="GET" >
        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
          <div class="input-group m-r mt-2 pr-5">
            <input type="text" class="form-control bg-light" name ="review_code" placeholder="Receipt ID" aria-label="Search" value="<?php if (isset($_GET["review_code"])) echo $_GET["review_code"]; ?>">
            <div class="input-group-prepend">
              <input type="submit" class="input-group-text bg-dark text-white" id="btnGroupAddon" value="Search">
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="bg-primary text-white border border-dark mt-3 mb-3 p-2">
    
    
    <form action="" method="GET">
      <?php
          foreach ($results as $result) {
            // sku_code, name, price
            echo '<input type="radio" name="item" class="p-3 ml-2" value="'.$result['sku_code'].'">';
            echo '<label>'.$result['name']. " ". $result['sku_code'].'</label>';
            echo '</a>';
            echo '<br>';
            
          }
        ?>

    
    </div>
    <div class="bg-primary text-white border border-dark mt-3 mb-3 p-2">
    <input type="text" class="form-control bg-light" name ="review_code" placeholder="Receipt ID" aria-label="Search" value="<?php if (isset($_GET["review_code"])) echo $_GET["review_code"]; ?>">
    <div class="input-group-prepend">
    <input type="submit" class="input-group-text bg-dark text-white" id="btnGroupAddon" value="Search">
    <?php
          foreach ($results as $result) {
            // sku_code, name, price
            
            
          }
        ?>
  </form>
  
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
