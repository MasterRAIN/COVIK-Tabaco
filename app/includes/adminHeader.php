<header>
     <a href="<?php echo BASE_URL . '/index.php'; ?>" class="logo">
               <div class="seal"><img src="<?php echo BASE_URL . '/assets/images/covik-seal.png'; ?>" alt="Seal of Tabaco"></div>
               <h1 class="logo-text"><span>COVIK</span> Tabaco</h1>
     </a>
     <i class="fa fa-bars menu-toggle"></i>
     <ul class="nav">
          <li><a href="<?php echo BASE_URL . '/index.php' ?>">Home</a></li>
          <?php if (isset($_SESSION['id'])): ?>
               <li>
                    <a href="">
                         <i class="fa fa-user"></i>
                         <span><?php echo $_SESSION['username']; ?></span>
                         <i class="fa fa-chevron-down" style="font-size: 0.8em"></i>
                    </a>
                    <ul>
                         <li><a href="<?php echo BASE_URL . "/logout.php"; ?>" class="logout">Logout</a></li>
                    </ul>
               </li>
          <?php endif; ?>
     </ul>
</header>
