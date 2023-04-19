<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if(!isset($_SESSION['verified_user_id'])) : ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="login.php">LOGIN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="register.php">REGISTER</a>
          </li>
        <?php else : ?>
          <?php if(isset($_SESSION['verified_Superadmin'])) : ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="transaction_log.php">TRANSACTION LOG</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profiles.php">USERS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">INVENTORY</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="user_profile.php">PROFILE</a>
            </li>

            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="logout.php">LOGOUT</a>
            </li>

          <?php elseif (isset($_SESSION['verified_admin'])) : ?>
            
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">INVENTORY</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="user_profile.php">PROFILE</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="logout.php">LOGOUT</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="user_profile.php">PROFILE</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="logout.php">LOGOUT</a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
