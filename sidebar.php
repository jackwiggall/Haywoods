<!-- Sidebar/menu -->
<nav class="w3-sidebar bg-primary w3-collapse w3-top w3-large w3-padding text-white"
  style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft"
    style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Haywoods</b></h3>
  </div>
  <div class="w3-bar-block">
    <!--Index-->
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Product Search</a>
    <!--Library-->
    <a href="review.php" oncick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Write a Review</a>
    <!--Make review-->
    <a href="./internal/index.php" oncick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Haywoods
      Internal</a>
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