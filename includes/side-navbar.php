<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> DrinkSaOh </title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<style>
 @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    list-style: none;
    text-decoration: none;
    font-family: "Poppins", sans-serif;
  }
  .dashboard-container {
    width: 100%;
    height: 100%;
    background-color: #fff;
    display: flex;
  }
  .side-navbar {
    position: fixed;
    height: 100vh;
    width: 230px;
    background: #11101D;
    overflow: hidden;
    transition: all 0.5s ease;
    padding: 6px 12px;
  }
  .side-navbar ul {
    top: 0;
    left: 0;
    width: 100%;
  }
  .side-navbar ul li {
    width: 100%;
  }
  .side-navbar ul li:hover {
    background: none;
  }
  .side-navbar ul li:first-child {
    margin-bottom: 1rem;
    background: none;
  }
  .side-navbar ul li a {
    display: flex;
    width: 100%;
    color: #fff;
    border-radius: 12px;
    align-items: center;
    text-decoration: none;
    transition: all 0.4s ease;
    background: #11101D;
    font-family: "Poppins" , sans-serif;
  }
  .side-navbar ul li a .icon {
    color: #fff;
    height: 60px;
    min-width: 30px;
    font-size: 20px;
    text-align: center;
    line-height: 60px;
    margin-right: 10px;
    margin-left: 10px;
  }
  .side-navbar ul li a .text {
    color: #fff;
    font-size: 16px;
    font-weight: 400;
    white-space: nowrap;
    pointer-events: none;
    transition: 0.4s;
  }
  h2 {
    color: white;
  }
  .side-navbar .nav-list {
    margin-top: 20px;
    height: 100%;
    width: 100%;
    align-self: start;
  }
  @media (max-width: 420px) {
    .side-navbar li a .tooltip{
      display: none;
    }
  }
  .side-navbar li a .tooltip {
    position: absolute;
    top: -20px;
    left: calc(100% + 15px);
    z-index: 3;
    background: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 400;
    opacity: 0;
    white-space: nowrap;
    pointer-events: none;
    transition: 0s;
  }
  .side-navbar li:hover a .tooltip {
    opacity: 1;
    pointer-events: auto;
    transition: all 0.4s ease;
    top: 50%;
    transform: translateY(-50%);
  }
  .side-navbar li a .tooltip {
    display: none;
  }
  .side-navbar li a {
    display: flex;
    height: 100%;
    width: 100%;
    border-radius: 12px;
    align-items: center;
    text-decoration: none;
    transition: all 0.4s ease;
    background: #11101D;
    border-left: 3px solid transparent;
  }
  .side-navbar li a.side-link:hover{
    background: red;
  }
  .side-navbar li a.side-link.active{
    border-left: 3px solid red;
    border-bottom: 3px solid red;
  }
  .side-navbar.active ul li a .text {
    color: #fff;
    font-size: 15px;
    font-weight: 400;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: 0.4s;
  }
  .side-navbar.active li a .text{
    opacity: 1;
    pointer-events: auto;
  }
  .side-navbar li a.side-link:hover .text,
  .side-navbar li a.side-link:hover .icon{
    transition: all 0.5s ease;
    color: #11101D;
  }
  .content {
    position: absolute;
    width: calc(100% - 230px);
    left: 230px;
    max-height: 100vh;
    transition: 0.5s ease;
    overflow: auto;
    height: calc(100vh - 50px); 
  }
  .top-navbar {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 15px;
    box-shadow: 0 2px 4px rgb(0 0 0 / 10%);
    background: #11101D;
  }
  .profile img {
    width: 44px;
    height: 44px;
    object-fit: contain;
    object-position: center;
    border-radius: 50%;
    cursor: pointer;
  }
  #menu-icon {
    font-size: 34px;
    cursor: pointer;
    color: white;
  }
  .content.active {
    width: calc(100% - 80px);
    left: 80px;
  }
  .side-navbar.active {
    width: 80px;
  }
  .side-navbar li{
    position: relative;
    margin: 8px 0;
    list-style: none;
  }
  @media (max-width: 768px) {
    .content {
      width: 100%;
      left: 0;
    }
    .side-navbar {
      width: 80px;
      left: -80px;
    }
    .content.active {
      width: calc(100% - 80px);
      left: 80px;
    }
    .side-navbar.active {
      left: 0;
    }
  }

  @media (max-width: 768px) {
    .home-section {
        width: 100%;
        left: 80;
    }
    .side-navbar {
        width: 80px;
        left: -80px;
    }
    .home-section.active {
        width: calc(100% - 80px);
        left: 80px;
    }
    .side-navbar.active {
        left: 80;
    }
    .side-navbar ~ .home-section {
        left: 80px;
        width: calc(100% - 80px);
    }
    .side-navbar ~ .home-section.active {
        left: 80px;
        width: calc(100% - 80px);
    }
  }
  .side-navbar li .tooltip{
    position: absolute;
    top: -20px;
    left: calc(100% + 15px);
    z-index: 3;
    background: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 400;
    opacity: 0;
    white-space: nowrap;
    pointer-events: none;
    transition: 0s;
  }
  .side-navbar li:hover .tooltip{
    opacity: 1;
    pointer-events: auto;
    transition: all 0.4s ease;
    top: 50%;
    transform: translateY(-50%);
  }
  .side-navbar.active li .tooltip{
    display: none;
  }
  @media (max-width: 420px) {
    .side-navbar li .tooltip{
      display: none;
    }
  }
  .home-section{
    position: relative;
    background: #f6f6f6;
    max-height: 100vh;
    top: 0;
    transition: all 0.5s ease;
    justify-content: center;
    align-items: center;
    margin: 15px;
  }
  .side-navbar.active ~ .home-section{
    left: 230px;
    width: calc(100% - 230px);
  }
  .side-navbar li.logout {
    position: fixed;
    height: 60px;
    width: 230px;
    left: 0;
    bottom: -8px;
    padding: 10px 14px;
    background: #1d1b31;
    transition: all 0.5s ease;
    overflow: hidden;
  }
  .side-navbar.active li.logout {
    width: 80px;
  }
  .side-navbar .logout #log_out:hover {
    color: red;
  }
  .side-navbar .logout #log_out {
    position: absolute;
    top: 50%;
    right: 0;
    width: 80px;
    transform: translateY(-50%);
    background: #1d1b31;
    height: 60px;
    line-height: 60px;
    border-radius: 0;
    transition: all 0.5s ease;
    text-align: center;
  }
  .side-navbar .logout .links_name {
    display: inline-block;
    margin-left: 10px;
  }
  @media (max-width: 768px) {
    .home-section {
      width: 100%;
      left: 0;
    }
    .side-navbar li.logout {
      width: 80px;
      left: -80px;
      transition: all 0.5s ease;
    }
    .side-navbar.active li.logout {
      left: 0;
    }
    .home-section.active {
      width: calc(100% - 80px);
      left: 80px;
      transition: all 0.5s ease;
    }
    .side-navbar li.logout.active {
      left: 0;
    }
    .side-navbar li.logout ~ .home-section {
      left: 80px;
      width: calc(100% - 80px);
      transition: all 0.5s ease;
    }
    .side-navbar li.logout ~ .home-section.active {
      left: 80px;
      width: calc(100% - 80px);
      transition: all 0.5s ease;
    }
  }
</style>
</head>

<body>
  <div class="dashboard-container">
    <aside class="side-navbar">
      <ul class="nav-list">
        <li>
          <a>
            <span class="icon"><ion-icon name="cube-outline"></ion-icon></i></span>
            <span class="text"><h2> DrinkSaOh </h2></span>
          </a>
        </li>
        <?php if(!isset($_SESSION['verified_user_id'])) : ?>
          <li class="side-item">
            <a class="side-link" aria-current="page" href="login.php">LOGIN</a>
        </li>
        <li class="side-item">
          <a class="side-link" aria-current="page" href="register.php">REGISTER</a>
        </li>
        <?php else : ?>
          <?php if(isset($_SESSION['verified_Superadmin'])) : ?>
            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="home.php">
                <span class="icon"> <ion-icon name="home-outline"></ion-icon> </span>
                <span class="text">Home</span>
              </a>
                <span class="tooltip"> Home </span>
            </li>
            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "index.php") echo "active"; ?>" href="index.php">
                <span class="icon"> <ion-icon name="clipboard-outline"></ion-icon> </span>
                <span class="text">Inventory</span>
              </a>
                <span class="tooltip"> Inventory </span>
            </li>
            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "transaction_log.php") echo "active"; ?>" href="transaction_log.php">
                <span class="icon"> <ion-icon name="checkmark-done-outline"></ion-icon> </span>
                <span class="text">Transactions</span>
              </a>
                <span class="tooltip"> Transactions </span>
            </li>
            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "profiles.php") echo "active"; ?>" href="profiles.php">
                <span class="icon"> <ion-icon name="people-outline"></ion-icon> </span>
                <span class="text">Users</span>
              </a>
                <span class="tooltip"> Users </span>
            </li>
            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "user_profile.php") echo "active"; ?>" href="user_profile.php">
                <span class="icon"> <ion-icon name="person-outline"></ion-icon> </span>
                <span class="text">Profile</span>
              </a>
                <span class="tooltip"> Profile </span>
            </li>
            <li class="logout">      
              <a class="side-link" href="logout.php" aria-current="page">
                <i class='bx bx-log-out' id="log_out" ></i>
                <span class="links_name"> Logout </span>
              </a>
                <span class="tooltip"> Logout </span>
            </li>
            </li>
            <?php elseif (isset($_SESSION['verified_admin'])) : ?>
              <li>
                <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="home.php">
                  <span class="icon"> <ion-icon name="home-outline"></ion-icon> </span>
                  <span class="text">Home</span>
                </a>
                  <span class="tooltip"> Home </span>
              </li>
              <li>
                <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "index.php") echo "active"; ?>" href="index.php">
                  <span class="icon"> <ion-icon name="clipboard-outline"></ion-icon> </span>
                  <span class="text">Inventory</span>
                </a>
                  <span class="tooltip"> Inventory </span>
              </li>
              <li>
                <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "user_profile.php") echo "active"; ?>" href="user_profile.php">
                  <span class="icon"> <ion-icon name="person-outline"></ion-icon> </span>
                  <span class="text">Profile</span>
                </a>
                  <span class="tooltip"> Profile </span>
              </li>
              <li class="logout">      
                <a class="side-link" href="logout.php" aria-current="page">
                  <i class='bx bx-log-out' id="log_out" ></i>
                  <span class="links_name"> Logout </span>
                </a>
                  <span class="tooltip"> Logout </span>
              </li>
                <?php endif; ?>
                <?php endif; ?>
      </ul>
    </aside>
  </div>
    <div class="content">
      <div class="top-navbar">
        <div class="bx bx-menu" id="menu-icon"></div>
          <div class="profile">
            <img src="img/profile.jpg" alt="">
          </div>
      </div>
      <main class="home-section"> </main>
    
 <script>
    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');

    menu.onclick = () => {
      sidenavbar.classList.toggle('active');
      content.classList.toggle('active');
    }

    function menuBtnChange() {
      if(sidebar.classList.contains("active")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
      }
    }
  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  
</body>
</html>