<?php

include_once(ROOT_PATH . "/app/database/db.php");
include_once(ROOT_PATH . "/app/helpers/middleware.php");
include_once(ROOT_PATH . "/app/helpers/validateUser.php");

$table = 'users';

$admin_users = selectAll($table, ['admin']);

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


function loginUser($user) {
     $_SESSION['id'] = $user['id'];
     $_SESSION['username'] = $user['username'];    
     $_SESSION['admin'] = $user['admin'];
     $_SESSION['message'] = 'You are now logged in';
     $_SESSION['type'] = 'success';

     if ($_SESSION['admin']) {
          header('location: ' . BASE_URL . '/admin/dashboard.php');
     } else {
          header('location: ' . BASE_URL . '/index.php');
     }
     exit();
}

if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {
    $errors = validateUser($_POST);

     if (count($errors) === 0) {
          unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin']);
          $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

          if (isset($_POST['admin'])) {
               $_POST['admin'] = 1;
               $user_id = create($table, $_POST);
               $_SESSION['message'] = 'Admin user created successfully';
               $_SESSION['type'] = 'success';
               header('location: ' . BASE_URL . '/admin/users/index.php');
               exit();
               
          } else {
               $count = delete('requests', $_POST['request_id']);
               unset($_POST['request_id']);

               $_POST['admin'] = 0;
               $user_id = create($table, $_POST);
               $user = selectOne($table, ['id' => $user_id]);

               $_SESSION['message'] = 'User request approved successfully. Please check sent notification email.';
               $_SESSION['type'] = 'success';
               header('location: ' . BASE_URL . '/admin/users/requests.php');
               include(ROOT_PATH . "/assets/requestApprovedMailer.php");
               exit();
               //loginUser($user);   
          }
     } else {
          $fullname = $_POST['fullname'];
          $username = $_POST['username'];
          $position = $_POST['position'];
          $department = $_POST['department'];
          $employeeId = $_POST['employeeId'];
          $admin = isset($_POST['admin']) ? 1 : 0;
          $email = $_POST['email'];
          $password = $_POST['password'];
          $passwordConf = $_POST['passwordConf'];
     }
}



if (isset($_POST['update-user'])) {
     adminOnly();
     $errors = validateUser($_POST);

     if (count($errors) === 0) {
          $id = $_POST['id'];
          unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);
               
          //to prevent double hashing
          if(!empty($_POST['password'])){
               $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          }
          //unset to avoid being uncluded in the update
          else{
               unset($_POST['password']);
          }

          $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
          $count = update($table, $id, $_POST);
          $_SESSION['message'] = 'User updated successfully';
          $_SESSION['type'] = 'success';
          header('location: ' . BASE_URL . '/admin/users/index.php');
          exit();
          
     } else {
          $id = $_POST['id'];
          $fullname = $_POST['fullname'];
          $username = $_POST['username'];
          $position = $_POST['position'];
          $department = $_POST['department'];
          $employeeId = $_POST['employeeId'];
          $admin = isset($_POST['admin']) ? 1 : 0;
          $email = $_POST['email'];
          $password = $_POST['password'];
          $passwordConf = $_POST['passwordConf'];
     }
}

if (isset($_GET['id'])) {
     $user = selectOne($table, ['id' => $_GET['id']]);
     $id = $user['id'];
     $username = $user['username'];
     $admin = $user['admin'];
     $email = $user['email'];
     $fullname = $user['fullname'];
     $position = $user['position'];
     $department = $user['department'];
     $employeeId = $user['employeeId'];
}


if (isset($_POST['login-btn'])) {
     $errors = validateLogin($_POST);

     if (count($errors) === 0) {
          $user = selectOne($table, ['username' => $_POST['username']]);

          if ($user && password_verify($_POST['password'], $user['password'])) {   
               loginUser($user);   
          } else {
               array_push($errors, 'Wrong credentials');
          }
     }

     $username = $_POST['username'];
     $password = $_POST['password'];
}

if (isset($_GET['delete_id'])) {
     adminOnly();
     $count = delete($table, $_GET['delete_id']);
     $_SESSION['message'] = 'User deleted successfully';
     $_SESSION['type'] = 'success';
     header('location: ' . BASE_URL . '/admin/users/index.php');
     exit();
}