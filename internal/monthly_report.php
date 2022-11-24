<?php

require './access_level.php';
requireAccessLevel(1);

?>

<!DOCTYPE html>
<html>
  <?php require './login_banner.php'; ?>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Monthly Report</title>
    <link rel="stylesheet" href="../styles.css">
  </head>

  <body>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Monthly Report</h1>

      <div class="container border border-dark bg-info p-2 mb-2">
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Monthly Report</th>
            <td>May</td>
          </tr>
        </table>
      </div>

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Sale Details</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Cash Sales</th>
            <th>Card Sales</th>
            <th>Total</th>
          </tr>
          <tr>
            <td>£10,400.01</td>
            <td>£66,123.30</td>
            <th>£76,523.31</th>
          </tr>
        </table>
      </div>

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Top 5 Sellers</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Name</th>
            <th>SKU Code</th>
            <th>Sold</th>
          </tr>
          <tr> <!--1 of 5-->
            <td>TV Stand</td>
            <td>125160</td>
            <td>20</td>
          </tr>
          <tr> <!--2 of 5-->
            <td>Bedside Cabinet</td>
            <td>123012</td>
            <td>16</td>
          </tr>
          <tr> <!--3 of 5-->
            <td>Bed Frame</td>
            <td>124019</td>
            <td>15</td>
          </tr>
          <tr> <!--4 of 5-->
            <td>Table</td>
            <td>121022</td>
            <td>14</td>
          </tr>
          <tr> <!--5 of 5-->
            <td>Sofa</td>
            <td>125159</td>
            <td>12</td>
          </tr>
        </table>
      </div>

      <div class="container border border-dark bg-info p-2 mb-2">
        <h3 class="p-3 border border-dark bg-light">Employee Pay</h3>
        <table class="table table-bordered border-dark bg-light">
          <tr>
            <th>Hours</th>
            <th>Pay</th>
          </tr>
          <tr>
            <td>520</td>
            <td>£4732.00</td>
          </tr>
        </table>
      </div>


    </div>
  </body>

</html>