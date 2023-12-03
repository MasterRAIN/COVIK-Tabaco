<?php include("../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");
adminOnly();
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

     <link rel="stylesheet" href="../assets/css/style.css" />

     <link rel="stylesheet" href="../assets/css/admin.css" />

     <title>Admin Section - Dashboard</title>

</head>
     <body class="admin-body">
          <!--ADMIN HEADER HERE...-->
          <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

          <!-- ADMIN PAGE WRAPPER-->
          <div class="admin-wrapper">

               <!--LEFT SIDEBAR-->
               <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

               <!--ADMIN CONTENT-->
               <div class="admin-content dashboard">

                    <div class="content">
                         <h2 class="page-title">Dashboard</h2>

                         <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

                         <!--DASHBOARD CODE HERE-->

                         <div class="dashboard-content">
                              <div class="cards">
                                   <div class="card">
                                        <div class="box">
                                             <?php

                                             $sql = "SELECT id FROM posts ORDER BY id";
                                             $stmt = mysqli_query($conn, $sql);
                                             $records = mysqli_num_rows($stmt);

                                             echo '<h1>'.$records.'</h1>'
                                             ?>
                                             <h4>Posts</h4>
                                        </div>
                                        <div class="icon-case">
                                             <img src="../assets/images/post.png" alt=""></i>
                                        </div>
                                   </div>
                                   <div class="card">
                                        <div class="box">
                                             <?php

                                             $sql = "SELECT id FROM users ORDER BY id";
                                             $stmt = mysqli_query($conn, $sql);
                                             $records = mysqli_num_rows($stmt);

                                             echo '<h1>'.$records.'</h1>'
                                             ?>
                                             <h4>Users</h4>
                                        </div>
                                        <div class="icon-case">
                                             <img src="../assets/images/admin.png" alt=""></i>
                                        </div>
                                   </div>
                                   <div class="card">
                                        <div class="box">
                                             <?php

                                             $sql = "SELECT id FROM topics ORDER BY id";
                                             $stmt = mysqli_query($conn, $sql);
                                             $records = mysqli_num_rows($stmt);

                                             echo '<h1>'.$records.'</h1>'
                                             ?>
                                             <h4>Topics</h4>
                                        </div>
                                        <div class="icon-case">
                                             <img src="../assets/images/topic.png" alt=""></i>
                                        </div>
                                   </div>
                                   <div class="card">
                                        <div class="box">
                                             <?php

                                             $sql = "SELECT published FROM posts WHERE published = 0 ORDER BY id";
                                             $stmt = mysqli_query($conn, $sql);
                                             $records = mysqli_num_rows($stmt);

                                             echo '<h1>'.$records.'</h1>'
                                             ?>
                                             <h4>Not</h4><h4 id="unPub">published</h4>
                                        </div>
                                        <div class="icon-case unpub-case">
                                             <img src="../assets/images/unpublished.png" alt=""></i>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="dashboard-content-2">
                              <div class="dashboard-recent-posts">
                                   <div class="bot-cards dashboard-recent-post">
                                        <div class="card-name">
                                             <h2>Recent Posts</h2>
                                        </div>
                                        <table>
                                        <?php foreach ($recent as $post): ?>

                                             <?php 
                                                  $sql = "SELECT `username` FROM `users` WHERE `id` = ?";

                                                  $stmt = executeQuery($sql, ['id' => $post['user_id']]);
                                                  $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                             ?>
                                             <tr>
                                                  <div class="dashboard-recent">
                                                       <h3><?php echo $post['title']; ?></h3>
                                                       <p class="p-title">Created by: <?php echo $records[0]['username']; ?></p>
                                                       <p class="p-title">Created at: <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
                                                  </div>
                                             </tr>
                                        <?php endforeach; ?>
                                        </table>
                                   </div>
                              </div>
                              <div class="dashboard-popular-topics">
                                   <div class="bot-cards popular-topic">
                                        <div class="card-name">
                                             <h2>Topics</h2>
                                        </div>
                                        <table>
                                             <thead>
                                                  <tr class="bot-cards-tr">
                                                       <th class="bot-cards-tr-th">Name</th>
                                                       <th class="bot-cards-tr-th">Number of Posts</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                  $sql = "SELECT t.name as 'Topic', COUNT(p.id) as 'Post'
                                                            FROM `topics` as t 
                                                            INNER JOIN `posts` as p 
                                                            ON t.id = p.topic_id
                                                            GROUP BY t.name ORDER BY COUNT(p.id) DESC";

                                                  $results = $conn->query($sql);
                                                  if($results->num_rows) {
                                                       $rows = $results->fetch_all(MYSQLI_ASSOC);
                                                  }
                                                  ?>

                                                  <?php foreach ($rows as $row): ?> 

                                                       <tr>
                                                            <td class="bot-cards-tr-td"><?php echo $row['Topic']; ?></td>
                                                            <td class="bot-cards-tr-td"><?php echo $row['Post']; ?></td>
                                                       </tr>
                                                            
                                                  <?php endforeach; ?>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                         </div>
                         
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
          <script src="../assets/js/script.js"></script>
          
     </body>
</html>
