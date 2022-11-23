<?php
// have items send to self in post request,
// add to cookie
// parse cookie in table

session_start();

if (isset($_POST["sku"])) {
  $scanned_sku = $_POST["sku"];

  if (!isset($_SESSION["scanned_items"])) {
    $_SESSION["scanned_items"] = "[]";
  }
  $scanned_items = json_decode($_SESSION["scanned_items"]);

  // add to array
  $scanned_items[] = $scanned_sku;

}


?>


<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Till</title>
    <link rel="stylesheet" href="/styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Till</h1>

      <div class="container border border-dark bg-info p-2 mb-2">
        <div class="row p-2">
          <div class="col"> <!--Table-->
            <h4>scanned items</h4>
            <table class="table table-bordered border-dark bg-light it-pr">
              <tr>
                <th>Sku code</th>
                <th>Description</th>
                <th>Price</th>
              </tr>
              <tr>
                <td>Table</td>
                <td>£40</td>
              </tr>
              <tr>
                <td>Seat</td>
                <td>£50</td>
              </tr>
            </table>
            <form action="" method="POST">
              <input type="number" class="bg-light p-2" name="sku" placeholder="SKU Code">
              <input type="submit" value="Scan" class="btn btn-primary p-2 border border-dark w110">
            </form>
          </div>
        <div class="col"> <!--Buttons-->
          <h3 class="p-3 border border-dark bg-light w300">Total £90</h3><br>
          <input type="submit" value="Reset Trans" class="btn btn-primary mt-1 border border-dark w300" action=""><br>
          <input type="submit" value="Pay Card" class="btn btn-primary mt-1 border border-dark w300" action=""><br>
          <input type="submit" value="Pay Cash" class="btn btn-primary mt-1 border border-dark w300" action=""><br>
          <button class="btn btn-success mt-1 border border-dark w300 h100" action="">CONFIRM<br/>Received<br/>Money</button><!--change shade/tone-->
        </div>
      </div>
    </div>
  </body>

</html>
