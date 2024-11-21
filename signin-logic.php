<?php
// session_start();
require 'config/database.php';

if(isset($_POST['submit'])){
    //get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username_email){
        $_SESSION['signin'] = "Username or Email required";
    }elseif(!$password){
        $_SESSION['signin'] = "Password Required";
    }else{
        //fetch user from database
        $fetch_user_query = "select * from users where username='$username_email' or 
        email='$username_email'";

        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_result)==1){
            // convert the record into associative array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            // compare that form password with the database password
            if(password_verify($password, $db_password)){
                // set session for the access control
                $_SESSION['user-id'] = $user_record['id'];
                // set session if user is an admin
                if($user_record['is_admin'] == 1){
                    $_SESSION['user_is_admin'] = true;
                }
                // log the user in
                header('location: ' . ROOT_URL . 'admin/');
            }else{
                // password not matched
                $_SESSION['signin'] = "Incorrect password.";
            }
        }else{
            // user not found
            $_SESSION['signin'] = "User not found";
        }
    }
    // if any problem, redirecting back to signin  page with login data
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data']=$_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
}else{
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}