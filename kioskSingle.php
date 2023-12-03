<?php include("path.php") ?>
<?php include(ROOT_PATH . '/app/controllers/posts.php');


$topics = selectAll('topics');
$posts = selectAll('posts', ['published' => 1 ]);
$postsTitle = 'Recent Posts';

/*if (isset($_GET['id'])) {
     $post = selectOne('posts', ['id' => $_GET['id']]);
     
}*/

/*if (isset($_GET['t_id'])) {
     $recent = getLatestPostByTopicId($_GET['t_id']); 
     $recents = getPostsByTopicId($_GET['t_id']); 
     $postsTitle = "". $_GET['name'] . "";
} else if (isset($_POST['search-term'])) {
     $postsTitle = "You searched for '" . $_POST['search-term'] . "' ";
     $recent = searchPosts($_POST['search-term']);
     $recents = searchPosts($_POST['search-term']);
} else {
     $posts = getPublishedPosts();
}*/
if (isset($_GET['t_id']) && isset($_GET['p_id'])) {

     $recent = getLatestPostByTopicId_2($_GET['p_id']); 
     $recents = getPaginatedPostsByTopicId_2($_GET['t_id'], $_GET['p_id']); 

} else if (isset($_GET['t_id'])) {

     $recent = getLatestPostByTopicId($_GET['t_id']);
     $recents = getPaginatedPostsByTopicId_2($_GET['t_id'], $recent[0]['id']);
     $_GET['p_id'] = $recent[0]['id'];
     $_GET['title'] = $recent[0]['title'];
     
} else {
     exit(header('Location:kiosk.php'));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">

     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="assets/css/style.css" />
     <link rel="stylesheet" href="assets/css/kiosk.css" />

     <title> <?php foreach ($recent as $post): ?>
                         <?php 
                              $sql = "SELECT `username` FROM `users` WHERE `id` = ?";

                              $stmt = executeQuery($sql, ['id' => $post['user_id']]);
                              $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                         ?>
                         <?php echo $post['title']; ?>
                         <?php endforeach; ?> | COVIK Tabaco</title>
</head>
<body>

     <!--JAVASCRIPT FACEBOOK PAGE PLUGIN SDK-->
     <div id="fb-root"></div>
     <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0" nonce="gaLLoeMP"></script>

     <?php include(ROOT_PATH . "/app/includes/kioskHeader.php"); ?>

     <!--PAGE WRAPPER-->
     <div class="page-wrapper">
          
          <!--CONTENT-->
          <div class="content clearfix">

               <!--MAIN CONTENT WRAPPER-->
               <div class="main-content-wrapper">
                    <div class="main-content single">
                    <div class="back-btn">
                         <!-- <a href="main.php">
                              <i class="fas fa-chevron-left"></i>
                         </a> -->
                         
                        <button class="btn-back-index" onclick="history.back()"> <i class="fas fa-arrow-left"></i>
                         
                    </div>
                    <?php foreach ($recent as $post): ?>
                         <?php 
                              $sql = "SELECT `username` FROM `users` WHERE `id` = ?";

                              $stmt = executeQuery($sql, ['id' => $post['user_id']]);
                              $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                         ?>
                         
                         <h1 class="post-title"><?php echo $post['title']; ?></h1>
                         <div class="author">
                              <i class="far fa-user"></i><span><span> <?php echo $records[0]['username']; ?></span>
                                        <span></span>&nbsp;<span></span>
                              <i class="far fa-calendar"></i><span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                         </div>
                         <div class="single-post-image">
                              <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="">
                         </div>
                         <div>
                              <?php echo html_entity_decode($post['body']); ?>
                         </div>
                    <?php endforeach; ?>
                    </div>
               </div>
               <!--MAIN CONTENT WRAPPER//-->

               <!--SIDEBAR-->
               <div class="sidebar single">

                    <!--FACEBOOK PLUGIN LOCATION-->
                    <div class="fb-page-link">
                         <div class="fb-page" data-href="https://web.facebook.com/commandcentertabaco" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://web.facebook.com/commandcentertabaco" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/commandcentertabaco">Tabaco City Covid-19 Command Center</a></blockquote>
                         </div>
                    </div>

                    <div class="section popular" id="kioskSingle-posts-container">
                         <h2 class="section-title">Related Posts</h2>
                         <?php
                              $skip = true;
                              foreach ($recents['records'] as $post){
                         ?>
                               <a href="kioskSingle.php?t_id=<?php echo $_GET['t_id']; ?>&p_id=<?php echo $post['id']; ?>&title=<?php echo $post['title']; ?>">
                                   <div class="main-single-post clearfix">
                                        <div class="related-post-image">
                                             <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="">
                                        </div>
                                        <div class="related-post-title">
                                             <div class="title">
                                                  <p class="p-title"><?php $strend = 50; if(strlen($post['title']) >= $strend): ?><?php echo substr($post['title'], 0, $strend) . '...'; ?><?php else: ?><?php echo substr($post['title'], 0, $strend); ?><?php endif;?></p>
                                                  <i class="far fa-calendar"><span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span></i>
                                             </div>
                                        </div>
                                   </div>
                              </a>
                         <?php
                              }
                         ?>

                         <div class="pagination-links">

                         <?php if ($recents['prevPage']): ?>
                              <a class = "side-page-btn" href="kioskSingle.php?t_id=<?php echo $_GET['t_id']; ?>&p_id=<?php echo $_GET['p_id']; ?>&title=<?php echo $_GET['title']; ?>&page=<?php echo $recents['prevPage']; ?>#kioskSingle-posts-container">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                         <?php else: ?>
                              <a class = "side-page-btn disabled" href="#">< Prev</a><?php if(isset($_GET['page'])): ?> <span class="page-num">-  Page <?php echo $_GET['page']?>  -</span> <?php endif;?>
                         <?php endif; ?>

                         <?php if ($recents['nextPage']): ?>
                              <a class = "side-page-btn" href="kioskSingle.php?t_id=<?php echo $_GET['t_id']; ?>&p_id=<?php echo $_GET['p_id']; ?>&title=<?php echo $_GET['title']; ?>&page=<?php echo $recents['nextPage']; ?>#kioskSingle-posts-container">Next ></a>
                         <?php else: ?>
                              <a class = "side-page-btn disabled" href="#">Next ></a>
                         <?php endif; ?>

                         </div>

                    </div>

               </div>
               <!--SIDEBAR//-->

          </div>
          <!--CONTENT//-->

     </div>
     <!--PAGE WRAPPER//-->

     <!--FOOTER-->
     <?php include(ROOT_PATH . "/app/includes/kioskFooter.php"); ?>
     <!--FOOTER//-->

     <!-- JQUERY-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--SLICK CAROUSEL-->
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

     <!--CUSTOM SCRIPT-->
     <script src="assets/js/script.js"></script>

</body>
</html>