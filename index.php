<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$posts = array();
$recents = array();
$postsTitle = 'Recent Posts';

if (isset($_GET['t_id'])) {
     $posts = getPublishedPosts($_GET['t_id']); 
     $recents = getPaginatedPostsByTopicId($_GET['t_id']);
     $postsTitle = "". $_GET['name'] . "";
} else if (isset($_GET['search-term'])) {
     $posts = getPublishedPosts();
     $recents = paginatedSearchPosts($_GET['search-term']);
     $postsTitle = "You searched for '" . $_GET['search-term'] . "' ";
} else {
     $posts = getPublishedPosts();
     $recents = getPaginatedRecentPosts();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge" />


	<link rel="shortcut icon" href="favicon.ico"/>
	<link rel="bookmark" href="favicon.ico"/>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="assets/css/style.css" />

     <title>COVIK - Tabaco City</title>

</head>
<body>
     
     <!-- HEADER -->
     <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
     <div class="home-msg">
          <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
     </div>
     

     <!--PAGE WRAPPER-->
     <div class="page-wrapper">
          <div class="layout-toggle">
               <label class="switch">
                    <a href="<?php echo BASE_URL . '/kiosk.php' ?>">
                         <div class=""></div>
                         <h6>Web Mode</h6>
                    </a>
               </label>
          </div> 
          <!--POST SLIDER-->
          <div class="post-slider">
               <h1 class="slider-title">Posts</h1>
               <i class="fas fa-chevron-left prev prev-next"></i>
               <i class="fas fa-chevron-right next prev-next"></i>

               <div class="post-wrapper">

                    <?php foreach ($posts as $post): ?>
                         <div class="post">
                              <a href="single.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image" /></a>
                              <div class="post-info">
                                   <h4>
                                        <a href="single.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>"><?php $strend = 50; if(strlen($post['title']) >= $strend): ?><?php echo substr($post['title'], 0, $strend) . '...'; ?><?php else: ?><?php echo substr($post['title'], 0, $strend); ?><?php endif;?></a>
                                   </h4>
                                   <div class="slider-auth-date">
                                        <i class="far fa-user"></i><span><?php echo $post['username']; ?></span>
                                        &nbsp;
                                        <i class="far fa-calendar"></i><span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                                   </div>
                              </div>
                         </div>
                    <?php endforeach; ?>
                    
               </div>
          </div>
          <!--POST SLIDER //-->

          <!--CONTENT-->
          <div class="content clearfix">
               <!--MAIN CONTENT-->
               <div class="main-content" id="posts-container">
                    <h1 class="recent-post-title"><?php echo $postsTitle ?></h1>

                    <?php foreach ($recents['records'] as $post): ?>
                         <?php 
                              $sql = "SELECT `username` FROM `users` WHERE `id` = ?";

                              $stmt = executeQuery($sql, ['id' => $post['user_id']]);
                              $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                         ?>

                         <div class="post clearfix">
                              <a href="single.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="post-image"></a>
                              <div class="post-preview">
                                   <h2><a href="single.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>"><?php $strend = 50; if(strlen($post['title']) >= $strend): ?><?php echo substr($post['title'], 0, $strend) . '...'; ?><?php else: ?><?php echo substr($post['title'], 0, $strend); ?><?php endif;?></a></h2>
                                   <i class="far fa-user"></i><span> <?php echo $records[0]['username']; ?></span>
                                   &nbsp;
                                   <i class="far fa-calendar"></i><span> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                                   <p class="preview-text">
                                        <?php echo substr(html_entity_decode($post['body']), 0, 125) . '...'; ?>
                                   </p>
                                   <a href="single.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>" class="btn read-more">Read More</a>
                              </div>
                         </div>

                    <?php endforeach; ?>

                    <div class="pagination-links">
                         
                         <!-- FOR CATEGORIES -->
                         <?php if (isset($_GET['t_id'])): ?>
                              <?php if ($recents['prevPage']): ?>
                                   <a class = "page-btn" href="<?php echo BASE_URL . '/index.php?t_id=' . $_GET['t_id'] . '&name=' . $_GET['name'] . '&page=' . $recents['prevPage']; ?>#posts-container">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class = "page-btn" href="<?php echo BASE_URL . '/index.php?t_id=' . $_GET['t_id'] . '&name=' . $_GET['name'] . '&page=' . $recents['nextPage']; ?>#posts-container">Next Page ></a>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">Next Page ></a>
                              <?php endif; ?>
                              
                         <!-- FOR SEARCHED POSTS -->
                         <?php elseif (isset($_GET['search-term'])): ?>
                              
                              <?php if ($recents['prevPage']): ?>
                                   <a class = "page-btn" href="index.php?search-term=<?php echo $_GET['search-term']; ?>&page=<?php echo $recents['prevPage']; ?>#posts-container">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class = "page-btn" href="index.php?search-term=<?php echo $_GET['search-term']; ?>&page=<?php echo $recents['nextPage']; ?>#posts-container">Next Page ></a>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">Next Page ></a>
                              <?php endif; ?>
                              

                         <!-- FOR ALL POSTS -->
                         <?php else: ?>

                              <?php if ($recents['prevPage']): ?>
                                   <a class = "page-btn" href="index.php?page=<?php echo $recents['prevPage']; ?>#posts-container">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">< Prev Page</a><?php if(isset($_GET['page'])): ?> <span>-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class = "page-btn" href="index.php?page=<?php echo $recents['nextPage']; ?>#posts-container">Next Page ></a>
                              <?php else: ?>
                                   <a class = "page-btn disabled" href="#">Next Page ></a>
                              <?php endif; ?>

                         
                         <?php endif; ?>
                    </div>

               </div>
               <!--MAIN CONTENT //-->
               <div class="sidebar-sticky sidebar">
                    <div class="section search">
                         <h2 class="section-title">Search</h2>
                         <div class="search-container">
                              <form action="index.php"  id="search-form" method="get">
                                   <button type="submit" class="search-form-btn" id="search-btn">
                                        <i class="fa fa-search"></i>
                                   </button>
                                   <input type="text" name="search-term" class="text-input contents" id="search-input" placeholder="Search..."></input>
                              </form>
                              <div>
                                   <button class="search-form-btn talk" id="speech-btn">
                                        <i class="fa fa-microphone"></i>
                                   </button>
                                   
                              </div>
                         </div>
                    </div>
                    

                    <div class="section topics">
                         <h2 class="section-title">Categories</h2>
                         <ul>
                              <?php foreach ($topics as $key => $topic): ?>
                                   <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic['name']; ?>"><?php echo $topic['name']; ?></a></li>
                              <?php endforeach; ?>
                         </ul>
                    </div>
               </div>
          </div>
          <!--CONTENT //-->
     </div>
     <!--PAGE WRAPPER //-->

     <!--FOOTER-->
     <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

     
     <script src="assets/js/app.js"></script>

     <!-- JQUERY-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <!--SLICK CAROUSEL-->
     <script
          type="text/javascript"
          src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
     ></script>

     <!--CUSTOM SCRIPT-->
     <script src="assets/js/script.js"></script>
</body>
</html>
