<?php

// session_start(); //we have passed the start session to constant
require 'config/database.php';



//get signup from data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //validate input values
    if(!$firstname){
        $_SESSION['signup'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['signup'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['signup'] = "Please enter your username";
    }elseif(!$email){
        $_SESSION['signup'] = "Please enter a valid email";
    }elseif(strlen($createpassword) < 8 || strlen(($confirmpassword) < 8 )  ){
        $_SESSION['signup'] = "Password should be 8+ characters";
    }elseif(!$avatar['name']){
        $_SESSION['signup'] = "Please add avatar";
    }else{
        // check if passwords don't match
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Passwords don't match";
        }else{
            // hash one of the password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT); 
            // echo $createpassword . "<br/>";
            // echo $hashed_password . "<br/>";

            //check if username or mail already exists in databaase
            $user_check_query="select * from users where username ='$username' or email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result)>0){
                $_SESSION['signup']="Username or Email already exists";
            }else{
                //work on avatar
                // rename avatar
                $time=time();// you can use Math.random();
                // make each image name unique using current tie stamp (it is unique since 1997)
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path =  'images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = array('jpg', 'jpeg', 'png', 'avif', 'webp');
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                //check for alllowed extension
                if(in_array($extension, $allowed_files)){
                    // make sure imageis not too large(1mb)
                    if($avatar['size'] < 1000000){
                        // upload avatar
                        move_uploaded_file($avatar_temp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup']= "file size too large. Should be less than 1mb";
                    }
                }else{
                    $_SESSION['signup'] = "file should be of type jpg/png/jpeg/avif/webp";
                }
            }
        }
    }

    // redirect back to signup page if there was a problem
    if(isset($_SESSION['signup'])){
        //pass form data back in signup page
        $_SESSION['signup-data']=$_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }else{
        //no problem in signup
        //insert new user into table
        $insert_user_query = "insert into users (firstname, lastname, username, email, password, avatar, is_admin) 
                    values ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
        
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        //if everything ends/goes well 
        if(!mysqli_errno($connection)){
            //redirect to login page with success message
            $_SESSION['signup-success']="Registeration successfully, Please log in";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }

}else{
    // if button wasn't clicked. bounce back to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}