<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    // get from data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title){
        $_SESSION['add-category'] = "Enter title";
    }elseif(!$description){
        $_SESSION['add-category'] = "Enter description";
    }
    // redirect back to add category page with form data if there was invalid input
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add_category.php');
        die();
    }else{
        // insert category into database
        $query ="insert into categories (title, description) values ('$title','$description')";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)){
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add_category.php');
            die();
        }else{
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location: ' . ROOT_URL . 'admin/manage_categories.php');
            die();
        }
    }
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
// just to check

// if(isset($_POST['submit'])){
//     $author_id = $_SESSION['user-id'];
//     $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     $category_id = filter_var($_POST['category'],  FILTER_SANITIZE_NUMBER_INT);
//     $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
//     $thumbnail = $_FILES['thumbnail'];

    
//     $is_featured = $is_featured == 1 ? : 0;

    
//     if(!$title){
//         $_SESSION['add-post'] = "Enter post title";
//     }elseif(!$category_id){
//         $_SESSION['add-post'] = "Select post category";
//     }elseif(!$body){
//         $_SESSION['add-post'] = "Enter post body";
//     }elseif(!$thumbnai['name']){
//         $_SESSION['add-post'] = "Upload post thumbnail";
//     }else{
        
//         $time = time(); 
//         $thumbnail_name = $time . $thumbnail['name'];
//         $thumbnail_tmp_name = $thumbnail['tmp_name'];
//         $thumbnail_destination_path = '../images/'. $thumbnail_name;


//         $allowed_files = ['png', 'jpg' , 'jpeg' , 'avif' , 'webp'];
//         $extension = explode('.',$thumbnail_name);
//         $extension = end($extension);
//         if(in_array($extension, $allowed_files)){
//             if($thumbnail['size'] < 2_000_000){
//                 move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
//             }else{
//                 $_SESSION['add-post'] = "Image size is too big. Should be less than 2mb";
//             }
//         }else{
//             $_SESSION['add-post'] = "Invalid image type. Only png/jpg/jpeg/webp/avif are acceptable"; 
//         }
//     }
//     if(isset($_SESSION['add-post'])){
//         $_SESSION['add-post-data'] = $_POST;
//         header('location:' . ROOT_URL . 'admin/add_post.php');
//         die();
//     }else{
//         if($is_featured == 1){
//             $zero_all_its_featured_query = "UPDATE posts SET is_featured=0";
//             $zero_all_its_featured_result = mysqli_query($connection, $zero_all_its_featured_query);
//         }
//         $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
//                     VALUES ('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', <<$is_featured)";
        
//         $result = mysqli_query($connection, $query);

//         if(!mysqli_errno($connection)){
//             $_SESSION['add-post-success'] = "New post added successfully";
//             header('location: ' . ROOT_URL. 'admin/');
//             die();
//         }
//     }
// }
// header('location: ' . ROOT_URL . 'admin/add_post.php');
// die();