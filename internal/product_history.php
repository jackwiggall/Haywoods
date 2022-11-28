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
<?php require './internal_sidebar.php'; ?>

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

</body>
</html>
