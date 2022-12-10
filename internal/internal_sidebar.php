<!-- Sidebar/menu -->
<nav class="w3-sidebar bg-dark w3-collapse w3-top w3-large w3-padding text-white"
  style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft"
    style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64 pb-3"><b>Haywoods<br>Internal</b></h3>
  </div>
  <div class="w3-bar-block">
    <!--Check access level? Add login/logout on bar? may need to change addresses-->
    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 'true') {
      echo "<p class='w3-bar-item w3-text-blue mt-0 pt-0 mb-5'>";
      echo "<b class='text-white'>Logged in as</b>";
      echo "<br><b class='text-white'>Name:</b> ";
      echo $_SESSION['fullname'];
      echo "<br><b class='text-white'>Role:</b> ";
      echo $_SESSION['accessLevelName'];
      echo "<br><b class='text-white'>Store:</b> ";
      echo $_SESSION['location'];
      echo "</p>";
      echo '<a href="./index.php" onclick="w3_open()" class="w3-bar-item w3-button w3-hover-white">Home</a>';

      if ($_SESSION['accessLevel'] <= 4) { // trainee
        echo "<a href='./till.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Till</a>";
      }
      if ($_SESSION['accessLevel'] <= 3) { // employee
        echo "<a href='./product_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Product History</a>";
      }
      if ($_SESSION['accessLevel'] <= 2) { // supervisor
        echo "<a href='./sale_history.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Sale History</a>";
      }
      if ($_SESSION['accessLevel'] == 1) { // management
        echo "<a href='./monthly_report.php' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Monthly Report</a>";
        echo "<a href='./manage_staff.php' onlock='w3_close()' class='w3-bar-item w3-button w3-hover-white'>Manage Staff</a>";
      }
      // pay details
      echo '<a href="./staff_pay.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Monthly Pay Details</a>';
      // logout
      echo '<a href="./login.php?logout=true" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Logout</a>';
    } else {
      // return to public site
      echo '<a href="../index.php?logout=true" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Return to Public Website</a>';
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
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"
  id="myOverlay"></div>


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