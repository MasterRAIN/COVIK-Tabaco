<?php 

function validateUser($user) {

     $errors = array();

     if (empty($user['fullname'])) {
          array_push($errors, 'Fullname is required');
     }

     if (empty($user['username'])) {
          array_push($errors, 'Username is required');
     }

     if (empty($user['position'])) {
          array_push($errors, 'Position is required');
     }

     if (empty($user['department'])) {
          array_push($errors, 'Department is required');
     }

     if (empty($user['employeeId'])) {
          array_push($errors, 'Username is required');
     }

     if (empty($user['email'])) {
          array_push($errors, 'Email is required');
     }

     if (empty($user['password'])) {
          if(isset($_POST['update-user']) == false){
               array_push($errors, 'Password is required');
          }
     }

     if ($user['passwordConf'] !== $user['password']) {
          array_push($errors, 'Password does not match');
     }

     $existingUser = selectOne('users', ['email' => $user['email']]);
     if ($existingUser) {
          if (isset($user['update-user']) && $existingUser['id'] != $user['id']) {
               array_push($errors, 'Email already exists.');
          }

          if (isset($user['create-admin'])) {
               array_push($errors, 'Email already exists');
          }
     }

     return $errors;
}


function validateLogin($user) {

     $errors = array();

     if (empty($user['username'])) {
          array_push($errors, 'Username is reqiured');
     }

     if (empty($user['password'])) {
          array_push($errors, 'Password is reqiured');
     }

     return $errors;
}