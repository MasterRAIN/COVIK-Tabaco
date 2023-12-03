<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$table = 'posts';
$recent = selectAllRecents($table);
$posts = array();
$postsTitle = 'Recent Posts';


if (isset($_GET['t_id'])) {
     $recent = getPostsByTopicId($_GET['t_id']); 
     $postsTitle = "". $_GET['name'] . "";
} else if (isset($_POST['search-term'])) {
     $postsTitle = "You searched for '" . $_POST['search-term'] . "' ";
     $recent = searchPosts($_POST['search-term']);
} else {
     $posts = getPublishedPosts();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge" />


     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <link rel="stylesheet" href="assets/css/style.css" />

     <title>About COVIK - Tabaco City</title>

</head>
<body>
     
     <!-- HEADER -->
     <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
     <div class="home-msg">
          <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
     </div>
     

     <!--PAGE WRAPPER-->
     <div class="page-wrapper">
         
        <h1 class="about-title">Developers of COVIK-Tabaco</h1>
            <div class="about-content-wrapper">
                
                <p class="about-content">COVIK-Tabaco is a project developed by Polytechnic Institute of Tabaco (PITA) Information Technology students Rainier C. Barbacena, and Tom Justine B Militante in collaboration with the Local Government of Tabaco City through the City Health Unit - Tabaco. The project started as a capstone project inspired to deter the threats of misinformation and improve the awareness and knowledge of the Tabaco city residents towards Covid-19 and public health.  
                </p>

                <br>

                <p class="about-content">COVIK-Tabaco (Covid-19 Virtual Information Kiosk) is a platform aimed to counter the threats of misinformation concerning
                    Covid-19, and to provide a centralized hub for credible information. 
                </p>
            </div>    

     </div>
     <!--PAGE WRAPPER //-->

     <!--FOOTER-->
     <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

     <!--CUSTOM SCRIPT-->
     <script src="assets/js/script.js"></script>
</body>
</html>
