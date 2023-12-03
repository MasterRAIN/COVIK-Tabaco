<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
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

     <title>Admin Section - Edit User</title>

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
                         <a href="create.php" class="btn btn-big">Add User</a>
                         <a href="index.php" class="btn btn-big">Manage Users</a>
                         <a href="requests.php" class="btn btn-big">User Requests</a>
                    </div>

                    <div class="content">
                         <h2 class="page-title">Edit User</h2>

                         <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                         <form action="edit.php" method="post">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              
                              <div>
                                   <label>Fullname</label>
                                   <input type="text" name="fullname" value="<?php echo $fullname; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Username</label>
                                   <input type="text" name="username" value="<?php echo $username; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Position</label>
                                   <input type="text" name="position" value="<?php echo $position; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Department</label>
                                   <input type="text" name="department" value="<?php echo $department; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Employee ID</label>
                                   <input type="text" name="employeeId" value="<?php echo $employeeId; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Email</label>
                                   <input type="email" name="email" value="<?php echo $email; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Password</label>
                                   <input type="password" name="password" value="<?php echo $password; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <label>Confirm Password</label>
                                   <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input admin-input">
                              </div>
                              <div>
                                   <?php if (isset($admin) && $admin == 1): ?>
                                        <label>
                                             <input type="checkbox" name="admin" checked>
                                             Admin
                                        </label>
                                   <?php else: ?>
                                        <label>
                                             <input type="checkbox" name="admin">
                                             Admin
                                        </label>
                                   <?php endif; ?>
                              </div>

                              <div>
                                   <button type="submit" name="update-user" class="btn btn-big">Update User</button>
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
