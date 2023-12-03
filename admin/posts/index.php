<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");




$authPosts = authPosts();
$sectionTitle = "Manage Posts";
if (isset($_GET['search-term'])) {
     $authPosts = authSearchPosts($_GET['search-term']);
     $posts = adminSearchPosts($_GET['search-term']);
     $sectionTitle = "You searched for '" . $_GET['search-term'] . "' ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge" />

     <link
          href="https://fonts.googleapis.com/css?family=Candal|Lora"
          rel="stylesheet"
     />

     <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


     <link
          rel="stylesheet"
          href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
          crossorigin="anonymous"
     />

     <link rel="stylesheet" href="../../assets/css/style.css" />

     <link rel="stylesheet" href="../../assets/css/admin.css" />

     <title>Admin Section - Manage Posts</title>

</head>
     <body class="admin-body">
          <!--ADMIN HEADER HERE...-->
          <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

          <!-- ADMIN PAGE WRAPPER-->
          <div class="admin-wrapper">

               <!--LEFT SIDEBAR-->
               <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

               <!--ADMIN CONTENT-->
               <div class="admin-content">
                    <div class="button-group">
                         <div class="manage-posts-btn">
                              <a href="create.php" class="btn btn-big">Add Post</a>
                              <a href="index.php" class="btn btn-big">Manage Posts</a>
                         </div>
                         <div class="admin-search-wrapper">
                              <div class="section search">
                                   <div class="search-container">
                                        <form action="index.php"  id="search-form" method="get">
                                             <button type="submit" class="search-form-btn" id="admin-search-btn">
                                                  <i class="fa fa-search"></i>
                                             </button>
                                             <input type="text" name="search-term" class="text-input contents" id="admin-search-input" placeholder="Search..."></input>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="content">
                         <h2 class="page-title"><?php echo $sectionTitle; ?></h2>

                         <?php include(ROOT_PATH . "/app/includes/messages.php") ?>

                         <table>
                              <thead class="thead">
                                   <th class="table-design">SN</th>
                                   <th class="table-design">Title</th>
                                   <th class="table-design">Author</th>
                                   <th class="table-design" colspan="3">Action</th>                               
                              </thead>
                              <tbody class="tbody">

                                   <?php if (empty($_SESSION['id']) || empty($_SESSION['admin'])): ?>
                                        <?php if (empty($authPosts)){
                                             $authPosts = [0][0];
                                        }
                                        ?>
                                        
                                        <?php if ($authPosts[0]['title'] !== null): ?>
                                             <?php foreach (array_reverse($authPosts) as $key => $post): ?>
                                                  <tr>

                                                       <td class="table-design"><?php echo $key + 1; ?></td>
                                                       <td class="table-design"><?php echo $post['title']; ?></td>

                                                       

                                                       <td class="table-design"><?php echo $post['username']; ?></td>
                                                       <td class="table-design"><a href="edit.php?id=<?php echo $post['id']; ?>" class="edit">Edit</a></td>
                                                       <td class="table-design"><a href="edit.php?delete_id=<?php echo $post['id']; ?>" class="delete">Delete</a></td>

                                                       <?php if ($post['published']): ?>
                                                            <td class="table-design"><a href="edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">Unpublish</a></td>
                                                       <?php else: ?>
                                                            <td class="table-design"><a href="edit.php?published=1&p_id=<?php echo$post['id'] ?>" class="publish">Publish</a></td>
                                                       <?php endif; ?>

                                                  </tr>
                                             <?php endforeach; ?>
                                        <?php else: ?>
                                             <?php echo "<h1 class='empty-posts'>No post found.</h1>"; ?>
                                        <?php endif; ?>

                                   <?php else: ?>
                                        <?php foreach (array_reverse($posts) as $key => $post): ?>
                                        <tr>
                                             <?php 
                                                  $sql = "SELECT `username` FROM `users` WHERE `id` = ?";

                                                  $stmt = executeQuery($sql, ['id' => $post['user_id']]);
                                                  $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                             ?>
                                             <td class="table-design"><?php echo $key + 1; ?></td>
                                             <td class="table-design"><?php echo $post['title'] ?></td>
                                             <td class="table-design"><?php echo $records[0]['username']; ?></td>
                                             <td class="table-design"><a href="edit.php?id=<?php echo $post['id']; ?>" class="edit">Edit</a></td>
                                             <td class="table-design"><a href="edit.php?delete_id=<?php echo $post['id']; ?>" class="delete">Delete</a></td>

                                             <?php if ($post['published']): ?>
                                                  <td class="table-design"><a href="edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">Unpublish</a></td>
                                             <?php else: ?>
                                                  <td class="table-design"><a href="edit.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">Publish</a></td>
                                             <?php endif; ?>

                                        </tr>
                                        <?php endforeach; ?>
                                        
                                   <?php endif;?> 
                              </tbody>
                         </table>
                    </div>
               </div>
               <!--ADMIN CONTENT//-->


          </div>
          <!--ADMIN PAGE WRAPPER//-->

          <!-- JQUERY-->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

          <!-- CKEDITOR -->
          <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>

          <!--CUSTOM SCRIPT-->
          <script src="../../assets/js/script.js"></script>
          
     </body>
</html>
