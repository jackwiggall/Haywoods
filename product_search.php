<!DOCTYPE html>


<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Product Search</title>
    <link rel="stylesheet" href="./styles.css">
  </head>

  <body>

    <?php

     $dbhost = "localhost";
     $dbuser = "admin";
     $dbpass = "securepass";
     $dbname = "store";

     // Create connection
     $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     echo "Connected successfully\n";

     $search "thing";
     $res = $conn -> query("SELECT price FROM Product WHERE sku_code = $search");
     if ($res) {
         $rows = $res->fetch_row();
  
     } 
     else {
         echo "sql error";
     }
    ?>
    <div class="container">
      <h1 class="text-center bg-primary text-light border border-dark p-2 mt-2">Product Search</h1>
      <div class="bg-info border border-dark mt-3 mb-3 p-2">
        <h3 class="pt-3">Search</h3>

        <!--Search input-->
        <form action="?" method="get">
          <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
            <div class="input-group m-r mt-2 pr-5">
              <input type="text" class="form-control bg-light" placeholder="Search" aria-label="Search">
              <div class="input-group-prepend">
                <div type="submit" class="input-group-text bg-primary text-white" id="btnGroupAddon">&#x1F50D;</div>
              </div>
              </div>
          <!--Minimum input-->
            <div class="input-group m-r mt-2 pr-5">
              <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white" id="btnGroupAddon">£></div>
              </div>
              <input type="text" class="form-control bg-light" placeholder="Min" aria-label="Min" aria-describedby="btnGroupAddon">
            </div>
            <!--Maxium input-->
            <div class="input-group mt-2">
              <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white" id="btnGroupAddon">£<</div>
              </div>
              <input type="text" class="form-control bg-light" placeholder="Max" aria-label="Max" aria-describedby="btnGroupAddon">
            </div>
          </div>
        </form>
      </div>

      <div class="card-deck">
        <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
          <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--1 of 8-->
            <div class="card-body">
              <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
              <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
            </div></a>
          </div>
          <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
            <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--2 of 8-->
              <div class="card-body">
                <p class="card-text text-white bg-primary pl-1 border border-dark">£39.00</p>
                <p class="card-text text-white bg-primary pl-1 border border-dark d-block">Bedside Cabinet</p>
              </div></a>
            </div>
            <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
              <a href="#"><img src="blank.png" class="card-img-top border border-dark" alt="..."> <!--3 of 8-->
                <div class="card-body">
                  <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
                  <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
                </div></a>
              </div>
              <div class="card bg-info border border-dark p-2 mb-2 m-r d-inline-block c-width">
                <a href="#"><img src="blank.png" class="card-img-top" alt="..."> <!--4 of 8-->
                  <div class="card-body">
                    <p class="card-text text-white bg-primary pl-1 border border-dark">£110.99</p>
                    <p class="card-text text-white bg-primary pl-1 border border-dark d-block">TV Stand</p>
                  </div></a>
                </div>
        </div>
    </div>
  </body>

</html>
