<?php include("path.php") ?>
<?php include(ROOT_PATH . "/app/controllers/requests.php");
guestsOnly();
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

     <title>Register</title>
</head>
<body>

     <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

     <div class="auth-content">

          <form action="register.php" method="post">

               <h2 class="form-title">Register</h2>

               <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
               
               <div>
                    <label>Fullname</label>
                    <input type="text" name="fullname" value="<?php echo $fullname; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Position</label>
                    <input type="text" name="position" value="<?php echo $position; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Department</label>
                    <input type="text" name="department" value="<?php echo $department; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Employee ID</label>
                    <input type="text" name="employeeId" value="<?php echo $employeeId; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo $password; ?>" class="text-input login-register">
               </div>
               <div>
                    <label>Confirm Password</label>
                    <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input login-register">
               </div>
               <div>
                    <button type="submit" name="register" class="btn btn-big">Register</button>
               </div> 
               <p><a href="<?php echo BASE_URL . '/login.php' ?>">Sign In</a></p>              


          </form>
     </div>

     <!-- Insert into 'request' table -->


     <!-- JQUERY-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

     <!--CUSTOM SCRIPT-->
     <script src="assets/js/script.js"></script>

</body>
</html>