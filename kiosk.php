<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$posts = array();
$recents = array();
$postsTitle = 'Recent Posts';


if (isset($_GET['t_id'])) {
     $posts = getPostsByTopicId($_GET['t_id']); 
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
     <link rel="stylesheet" href="assets/css/kiosk.css" />

     <title>COVIK - Tabaco City</title>

</head>
<body>
     
     <!-- HEADER -->
     <?php include(ROOT_PATH . "/app/includes/kioskHeader.php"); ?>
     <div class="home-msg"> 
          <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
     </div>

     
     <!--PAGE WRAPPER-->
     <div class="kiosk-content-wrapper">

          <div class="layout-toggle"> 
               <label class="switch">
                    <a href="<?php echo BASE_URL . '/index.php' ?>">
                         <div class=""></div>
                         <h6>Web Mode</h6>
                    </a>
               </label>
          </div>

          <div class="kiosk-main-section">

               <div class="kiosk-post-slider">
                    <h1 class="kiosk-slider-title">Posts</h1>
                    <i class="fas fa-chevron-left prev prev-next"></i>
                    <i class="fas fa-chevron-right next prev-next"></i>

                    <div class="kiosk-post-wrapper">

                         <?php foreach ($posts as $post): ?>

                                   <div class="kiosk-post">
                                        <a href="kioskSingle.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>">
                                             <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image" />
                                             <div class="kiosk-post-info">
                                                  <h5>
                                                  <?php $strend = 50; if(strlen($post['title']) >= $strend): ?><?php echo substr($post['title'], 0, $strend) . '...'; ?><?php else: ?><?php echo substr($post['title'], 0, $strend); ?><?php endif;?>
                                                  </h5>
                                                  <div class="post-auth-date">
                                                       <i class="far fa-user"></i><span> <?php echo $post['username']; ?></span>
                                                       &nbsp;
                                                       <i class="far fa-calendar"></i><span> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                                                  </div>
                                             </div>
                                        </a>
                                   </div>
                                   
                         <?php endforeach; ?> 
                                               
                    </div>
               </div>

               <div class="kiosk-topics">
                    <h1 class="categories-text">Categories</h1>
                    <div class="topic-categories">
                    
                         <?php foreach ($topics as $key => $topic): ?>

                              <li>
                                   <a href="<?php echo BASE_URL . '/kioskSingle.php?t_id=' . $topic['id'] . '&topic=' . $topic['name']; ?>">
                                        <div><?php echo $topic['name']; ?></div>
                                   </a>
                              </li>

                         <?php endforeach; ?>                
                    
                    </div>
               </div>
          </div>

          <div class="kiosk-search-section">
               <div class="kiosk-search-container">
                    <h1 class="search-text">Search</h1>
                    <div class="kiosk-search-form">
                         <form action="kiosk.php"  id="search-form" class="search-posts" method="get">
                              <button type="submit" class="kiosk-search-form-btn" id="search-btn">
                                   <i class="fa fa-search"></i>
                              </button>
                              <input type="text" name="search-term" class="text-input contents" id="search-input" placeholder="Search..."></input>
                         </form>
                         <div class="kiosk-speech">
                              <button class="kiosk-search-form-btn talk" id="speech-btn">
                                   <i class="fa fa-microphone"></i>
                              </button>
                         </div>
                    </div>
               </div>

               
               <div class="kiosk-recent-container" id="kiosk-posts-container">
                    <h2 class="recent-text"><?php echo $postsTitle ?></h2>
                         
                    <?php foreach ($recents['records'] as $post): ?>

                         <div class="kiosk-recent-posts">
                              <a href="kioskSingle.php?t_id=<?php echo $post['topic_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>">
                                   <div class="kiosk-recent-image">
                                        <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image" />
                                   </div>
                                   <div class="kiosk-recent-title">
                                        <p class="p-title"><?php $strend = 50; if(strlen($post['title']) >= $strend): ?><?php echo substr($post['title'], 0, $strend) . '...'; ?><?php else: ?><?php echo substr($post['title'], 0, $strend); ?><?php endif;?></p>
                                        <div>
                                             <i class="far fa-calendar"></i><span>     <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                                        </div>
                                   </div>
                              </a>
                         </div>
                         
                    <?php endforeach; ?> 
                    
                    <div class="pagination-links">
                         
                         <!-- FOR CATEGORIES -->
                         <?php if (isset($_GET['t_id'])): ?>
                              <?php if ($recents['prevPage']): ?>
                                   <a class = "recent-side-page-btn" href="<?php echo BASE_URL . '/kiosk.php?t_id=' . $_GET['t_id'] . '&name=' . $_GET['name'] . '&page=' . $recents['prevPage']; ?>#kiosk-posts-container">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class = "recent-side-page-btn disabled" href="#">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class = "recent-side-page-btn" href="<?php echo BASE_URL . '/kiosk.php?t_id=' . $_GET['t_id'] . '&name=' . $_GET['name'] . '&page=' . $recents['nextPage']; ?>#kiosk-posts-container">Next ></a>
                              <?php else: ?>
                                   <a class = "recent-side-page-btn disabled" href="#">Next ></a>
                              <?php endif; ?>
                              
                         <!-- FOR SEARCHED POSTS -->
                         <?php elseif (isset($_GET['search-term'])): ?>
                              
                              <?php if ($recents['prevPage']): ?>
                                   <a class = "recent-side-page-btn" href="kiosk.php?search-term=<?php echo $_GET['search-term']; ?>&page=<?php echo $recents['prevPage']; ?>#kiosk-posts-container">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class = "recent-side-page-btn disabled" href="#">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class ="recent-side-page-btn" href="kiosk.php?search-term=<?php echo $_GET['search-term']; ?>&page=<?php echo $recents['nextPage']; ?>#kiosk-posts-container">Next ></a>
                              <?php else: ?>
                                   <a class ="recent-side-page-btn disabled" href="#">Next ></a>
                              <?php endif; ?>
                              

                         <!-- FOR ALL POSTS -->
                         <?php else: ?>

                              <?php if ($recents['prevPage']): ?>
                                   <a class="recent-side-page-btn" href="kiosk.php?page=<?php echo $recents['prevPage']; ?>#kiosk-posts-container">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php else: ?>
                                   <a class="recent-side-page-btn disabled" href="#">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="recent-page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                              <?php endif; ?>

                              <?php if ($recents['nextPage']): ?>
                                   <a class="recent-side-page-btn" href="kiosk.php?page=<?php echo $recents['nextPage']; ?>#kiosk-posts-container">Next ></a>
                              <?php else: ?>
                                   <a class="recent-side-page-btn disabled" href="#">Next ></a>
                              <?php endif; ?>

                         
                         <?php endif; ?>
                         
                    </div>
               </div>
          </div>
     </div>
     <!--PAGE WRAPPER //-->

     <!--FOOTER-->
     <?php include(ROOT_PATH . "/app/includes/kioskFooter.php"); ?>

     
     <script src="assets/js/app.js"></script>

     <!-- JQUERY-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <!--SLICK CAROUSEL-->
     <script
          type="text/javascript"
          src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
     ></script>

     <!--CUSTOM SCRIPT-->
     <script src="assets/js/kiosk.js"></script>
</body>
</html>
