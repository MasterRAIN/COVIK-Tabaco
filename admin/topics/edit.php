<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/topics.php");
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

     <link rel="stylesheet" href="../../assets/css/style.css" />

     <link rel="stylesheet" href="../../assets/css/admin.css" />

     <title>Admin Section - Edit Topic</title>

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
                         <a href="create.php" class="btn btn-big">Add Topic</a>
                         <a href="index.php" class="btn btn-big">Manage Topic</a>
                    </div>

                    <div class="content">
                         <h2 class="page-title">Edit Topic</h2>

                         <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                         <form action="edit.php" method="post">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              <div>
                                   <label>Name</label>
                                   <input type="text" name="name" value="<?php echo $name; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Description</label>
                                   <textarea name="description" id="body"><?php echo $description; ?></textarea>
                              </div>
                              <div>
                                   <button type="submit" name="update-topic" class="btn btn-big">Update Topic</button>
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
