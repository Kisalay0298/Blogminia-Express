<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;  // Ensure is_featured is correctly set
    $thumbnail = $_FILES['thumbnail'];

    // Validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Upload post thumbnail";
    }

    // If there's an error, redirect back to the form
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add_post.php');
        die();
    } else {
        // Process thumbnail
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Check file type
        $allowed_files = ['png', 'jpg', 'jpeg', 'avif', 'webp'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
        
        if (in_array($extension, $allowed_files) && $thumbnail['size'] < 2_000_000) {
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
        } else {
            $_SESSION['add-post'] = "Invalid image type or size too big.";
            header('location: ' . ROOT_URL . 'admin/add_post.php');
            die();
        }

        // Insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
                  VALUES ('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', $is_featured)";
        
        if (mysqli_query($connection, $query)) {
            $_SESSION['add-post-success'] = "New post added successfully";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        } else {
            $_SESSION['add-post'] = "Failed to add post. Please try again.";
        }
    }
}
header('location: ' . ROOT_URL . 'admin/add_post.php');
die();

