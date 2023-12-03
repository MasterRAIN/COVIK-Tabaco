<?php

include_once(ROOT_PATH . "/app/database/db.php");
include_once(ROOT_PATH . "/app/helpers/middleware.php");
include_once(ROOT_PATH . "/app/helpers/validateUser.php");

$table = 'requests';

$requesters = selectAll($table);

$errors = array();
$id = '';
$username = '';
$admin = '';
$email = '';
$password = '';
$passwordConf = '';
$fullname = '';
$position = '';
$department = '';
$employeeId = '';


if (isset($_POST['register'])) {
     $errors = validateUser($_POST);
 
        if (count($errors) === 0) {
           unset($_POST['register'], $_POST['passwordConf']);
           //$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
           
           $_POST['admin'] = 0;
           $request_id = create($table, $_POST);
           $_SESSION['message'] = 'Registration request sent successfully, please stand by for the admin\'s approval';
           $_SESSION['type'] = 'success';
           header('location:' . BASE_URL);
           exit(); 
           }
        

       else {
           $fullname = $_POST['fullname'];
           $username = $_POST['username'];
           $position = $_POST['position'];
           $department = $_POST['department'];
           $employeeId = $_POST['employeeId'];
           $email = $_POST['email'];
           $password = $_POST['password'];
           $passwordConf = $_POST['passwordConf'];
      }

}

 if (isset($_GET['delete_id'])) {
      adminOnly();
      $count = delete($table, $_GET['delete_id']);
      $_SESSION['message'] = 'User request deleted successfully';
      $_SESSION['type'] = 'success';
      header('location: ' . BASE_URL . '/admin/users/requests.php');
      exit();
 }

 if (isset($_GET['request_id'])) {
  $userRequest = selectOne($table, ['id' => $_GET['request_id']]);
  $id = $userRequest['id'];
  $username = $userRequest['username'];
  $email = $userRequest['email'];
  $fullname = $userRequest['fullname'];
  $position = $userRequest['position'];
  $department = $userRequest['department'];
  $employeeId = $userRequest['employeeId'];
  $password = $userRequest['password'];
}
 