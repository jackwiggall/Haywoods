

<div>
  <?php
    $username = $_SESSION['username'];

    echo "logged in as $username, <a href='./login.php?logout=true'>Logout</a>";
  ?>
</div>