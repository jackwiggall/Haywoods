<?php

require './access_level.php';
requireAccessLevel(3);

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
<nav class="w3-sidebar bg-primary w3-collapse w3-top w3-large w3-padding text-white" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Haywoods<br>Internal</b></h3>
  </div>
  <?php
    if($accessLevel != -1){
      echo"<a href='./login.php?logout=true' class='w3-bar-item w3-button w3-hover-white'>User: $username, Access: $accessLevel</a>";
    }else{
      echo "<a href='./login.php' class='w3-bar-item w3-button w3-hover-white'>Login</a>";}
  ?> <!--logout/login-->
  <div class="w3-bar-block"> <!--Check access level? Add login/logout on bar? may need to change addresses-->
    <a href="./index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> <!--Index-->
    <?php
      if ($accessLevel <= 4) { // trainee
        echo "<a href='./till.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Till</a>";
      }
      if ($accessLevel <= 3) { // employee
        echo "<a href='./product_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Product History</a>";
      }
      if ($accessLevel <= 2) { // supervisor
        echo "<a href='./sale_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Sale History</a>";
      }
      if ($accessLevel == 1) { // management
        echo "<a href='./monthly_report.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Monthly Report</a>";
      }
    ?>
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
    <h1 class="w3-jumbo"><b>Product History</b></h1> <!--Page Title-->
    <h1 class="w3-xxxlarge text-primary"><b>SKU Code.</b></h1> <!--Sub title-->
    <hr style="width:50px;border:5px solid blue" class="w3-round">
    <div class="container bg-primary border border-dark p-2 dropshadow">
      <form action="?" method="get">
        <p class="d-inline-block border border-dark bg-light p-2">Product SKU:</p> <input type="text"
          class="bg-light p-2" name="sku" placeholder="000000"><br>
        <input type="submit" value="Search" class="btn btn-dark mt-1 border border-dark w300">
      </form>
    </div>
  </div>

  <!--History-->
  <?php if ($result) { #change to search thing
    echo "
    <div class='w3-container' style='margin-top:80px'>
      <h1 class='w3-xxxlarge text-primary'><b>${product_name}.</b></h1> <!--Sub title-->
      <hr style='width:50px;border:5px solid blue' class='w3-round'>
      <div class='container bg-primary border border-dark p-2 dropshadow'>
        <table class='table table-bordered border-dark bg-light'>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>Start Price</th>
            <th>End Price</th>
            <th>Start Stock</th>
            <th>End Stock</th>
            <th>Variance</th>
          </tr>
          <tr>
            <td>20/10/2022</td>
            <td>12:00:00</td>
            <td>Sale</td>
            <td>£100.99</td>
            <td>£100.99</td>
            <td>21</td>
            <td>20</td>
            <td>-1</td>
          </tr>
        </table>
      </div>
    </div>"; }
  ?>

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
