<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/requests.php");
adminOnly();
?>
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

     <title>Admin Section - User Requests</title>

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
                         <h2 class="page-title">User Requests</h2>

                         <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                         <table>
                              <thead class="thead">
                                   <th class="table-design">SN</th>
                                   <th class="table-design">Username</th>
                                   <th class="table-design">Email</th>
                                   <th class="table-design" colspan="3">Action</th>                               
                              </thead>
                              <tbody class="tbody">
                                   <?php foreach (array_reverse($requesters) as $key => $requester): ?>
                                        <tr>
                                             <td class="table-design"><?php echo $key + 1; ?></td>
                                             <td class="table-design"><?php echo $requester['username']; ?></td>
                                             <td class="table-design"><?php echo $requester['email']; ?></td>
                                             <td class="table-design">
                                                  <form action="requests.php" method="post">
                                                       <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                                                       <input type="hidden" name="fullname" value="<?php echo $requester['fullname']; ?>">
                                                       <input type="hidden" name="username" value="<?php echo $requester['username']; ?>">
                                                       <input type="hidden" name="position" value="<?php echo $requester['position']; ?>">
                                                       <input type="hidden" name="department" value="<?php echo $requester['department']; ?>">
                                                       <input type="hidden" name="employeeId" value="<?php echo $requester['employeeId']; ?>">
                                                       <input type="hidden" name="email" value="<?php echo $requester['email']; ?>">
                                                       <input type="hidden" name="password" value="<?php echo $requester['password']; ?>">
                                                       <input type="hidden" name="passwordConf" value="<?php echo $requester['password']; ?>">
                                                       <input type="hidden" name="request_id" value="<?php echo $requester['id']; ?>">
                                                       <button type="submit" name="register-btn" class="approve">Approve</button>
                                                  </form>
                                                  
                                             </td>
                                             <td class="table-design"><a href="requests.php?delete_id=<?php echo $requester['id']; ?>" class="delete">Decline</a></td>
                                             <td class="table-design"><a href="requestDetails.php?request_id=<?php echo $requester['id']; ?>" class="edit">Details</a></td>
                                        </tr>
                                   <?php endforeach; ?>
                                   
                              </tbody>
                         </table>

                         <?php if(empty($requesters)):?>
                              <h2 class="page-title">No user request</h2>
                         <?php endif;?>

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
