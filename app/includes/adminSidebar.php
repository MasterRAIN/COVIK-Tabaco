<div class="left-sidebar">

     <?php if (empty($_SESSION['id']) || empty($_SESSION['admin'])): ?>
          <ul>
               <li><a href="<?php echo BASE_URL . '/admin/posts/index.php'; ?>">Manage My Posts</a></li>
          </ul>
     <?php else: ?>
          <ul>
               <li><a href="<?php echo BASE_URL . '/admin/dashboard.php'; ?>">Dashboard</a></li>
               <li><a href="<?php echo BASE_URL . '/admin/posts/index.php'; ?>">Manage Posts</a></li>
               <li><a href="<?php echo BASE_URL . '/admin/users/index.php'; ?>">Manage Users</a></li>
               <li><a href="<?php echo BASE_URL . '/admin/topics/index.php'; ?>">Manage Topics</a></li>
          </ul>
     <?php endif; ?>

</div>