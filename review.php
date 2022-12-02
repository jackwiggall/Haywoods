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
<?php require './sidebar.php'; ?>

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


</body>
</html>
