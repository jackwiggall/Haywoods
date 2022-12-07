<?php

require './database.php';

$receiptItems = [];
if (isset($_GET['review_code'])) {
  $reviewCode = $_GET['review_code'];

  $stmt = $conn->prepare("SELECT sku_code, name
                          FROM vSaleItems
                          WHERE review_code = :review_code
                          GROUP BY sku_code"
                        );

  $stmt->bindParam("review_code", $reviewCode);
  
  $stmt->execute();
  $receiptItems = $stmt->fetchAll();
  
  // review
  if (isset($_POST['sku_code']) && !empty($_POST['sku_code']) && isset($_POST['rating']) && !empty($_POST['rating'])) {
    $sku_code = $_POST['sku_code'];
    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // check sku code is in reciept
    $skuInRecept = false;
    foreach ($receiptItems as $receiptItem) {
      if ($sku_code == $receiptItem['sku_code']) {
        $skuInRecept = true;
      }
    }
    if ($skuInRecept) {
      $stmt = $conn->prepare("INSERT INTO vReview (sku_code, rating, title, content)
                              VALUES (:sku_code, :rating, :title, :content)");
      $stmt->bindParam("sku_code", $sku_code);
      $stmt->bindParam("rating", $rating);
      $stmt->bindParam("title", $title);
      $stmt->bindParam("content", $content);
      $stmt->execute();
      // redirect
      header('location: ./review.php');
    }
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
    <link rel="stylesheet" href="./styles.css">
  </head>

  <body>

    <!-- Sidebar/menu -->
    <?php require './sidebar.php'; ?>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:340px;margin-right:40px">

      <!-- Header -->
      <div class="w3-container" style="margin-top:80px">
        <h1 class="w3-jumbo"><b>Review</b></h1>
        <!--Page Title-->
        <h1 class="w3-xxxlarge text-primary"><b>Write a review on a purchased item</b></h1>
        <!--Sub title-->
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <div class="bg-primary border border-dark mt-3 mb-3 p-2">
          <!--Search input-->
          <form action="" method="GET">
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
              <div class="input-group m-r mt-2 pr-5">
                <input type="text" class="form-control bg-light" name="review_code" placeholder="Review Code"
                  aria-label="Search" value="<?php if (isset($_GET["review_code"])) echo $_GET["review_code"]; ?>">
                <div class="input-group-prepend">
                  <input type="submit" class="input-group-text bg-dark text-white" id="btnGroupAddon" value="Search">
                </div>
              </div>
            </div>
          </form>
        </div>

        <?php
      if (empty($receiptItems)) {
        // show warning message if review code was entered and nothing was found (invalid review code)
        if (isset($_GET['review_code'])) {
          echo "<div class='w3-round container mt-4 p-2 bg-warning'>Receipt associated with review code not found on system</div>";
        }
        die("</div></body></html>");
      }
    ?>

        <form action="" method="POST" id="usrform">
          <div class="bg-primary text-white border border-dark mt-3 mb-3 p-2">
            <h2>select item from purchase to write review for</h2>
            <?php
          $checked = "checked";
          foreach ($receiptItems as $receiptItem) {
            // sku_code, name, price
            echo '<input type="radio" name="sku_code" class="p-3 ml-2" value="'.$receiptItem['sku_code'].'" '.$checked.'> ' ;
            echo '<label>'.$receiptItem['sku_code']. " - ". $receiptItem['name'].'</label>';
            echo '</a>';
            echo '<br>';
            $checked = "";
          }
        ?>
          </div>
          <div class="bg-primary text-white border border-dark mt-3 mb-3 p-2">
            <h2>Review item</h2>
            <p class="d-inline-block">Rating:</p>
            <input type="number" class="bg-light p-2" style="width: 60px;" min="0" max="10" name="rating" value="10"> of
            10<br>

            <!-- <p class="d-inline-block">Title:</p> -->
            <input type="text" class="bg-light p-2" name="title" placeholder="title"><br>
            <textarea placeholder="content" class="mt-2 mb-4" name="content" form="usrform"></textarea><br>

            <input type="submit" class="w300 bg-dark border border-light text-white p-3" value="Place Review">
          </div>
        </form>
      </div>
    </div>

  </body>

</html>