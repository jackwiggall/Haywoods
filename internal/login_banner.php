<div>
  <div class="row ps-2 pe-2 pt-1">
    <div class="col-2">
      <a href=".">Home</a>
    </div>
    <div class="col text-center">
      <?php
        $fullname = $_SESSION['fullname'];
        $username = $_SESSION['username'];
        $accessLevelName = $_SESSION['accessLevelName'];
        $store_location = $_SESSION['location'];
        echo "$fullname ($username), $accessLevelName, <strong>$store_location</strong>";
      ?>
    </div>
    <div class="col-2 text-end me-2">
      <a href='./login.php?logout=true'>Logout</a>
    </div>

  </div>
</div>
