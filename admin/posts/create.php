<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");

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

     <title>Admin Section - Add Post</title>

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
                         <a href="create.php" class="btn btn-big">Add Post</a>
                         <a href="index.php" class="btn btn-big">Manage Posts</a>
                    </div>

                    <div class="content">
                         <h2 class="page-title">Add Post</h2>

                         <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                         <form action="create.php" method="post" enctype="multipart/form-data" >
                              <div>
                                   <label>Title</label>
                                   <input type="text" name="title" value="<?php echo $title; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Body</label>
                                   <textarea name="body" id="body"><?php echo $body; ?></textarea>
                              </div>
                              <div>
                                   <label for=""></label>
                                   <input type="file" name="image" class="text-input" id="choose-file">
                              </div>
                              <div>
                                   <label>Topic</label>
                                   <select name="topic_id" class="text-input admin-input">
                                        <option value=""></option>
                                        <?php foreach ($topics as $key => $topic): ?>

                                             <?php if (!empty($topic_id) && $topic_id == $topic['id']): ?>
                                                  <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                             <?php else: ?>
                                                  <option value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                             <?php endif; ?>

                                        <?php endforeach; ?>
                                   </select>
                              </div>
                              <div>
                                   <?php if (empty($published)): ?>
                                        <label>
                                             <input type="checkbox" name="published">
                                             Publish
                                        </label>
                                   <?php else: ?>
                                        <label>
                                             <input type="checkbox" name="published" checked>
                                             Publish
                                        </label>
                                   <?php endif; ?>
                              </div>
                              <div>
                                   <button type="submit" name="add-post" class="btn btn-big">Add Post</button>
                              </div>
                         </form>
                         
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
