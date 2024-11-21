<?php
require 'config/database.php';
session_start();

// Make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if it was unchecked
    $is_featured = ($is_featured == 1) ? 1 : 0;

    // Initialize session variable for error messages
    if (!isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post'] = "";
    }

    // Validate input values
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } else {
        // Handle new thumbnail upload
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // Rename and move new thumbnail
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // Validate file type and size
            $allowed_files = ['png', 'jpg', 'jpeg', 'avif', 'webp'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

            if (in_array($extension, $allowed_files) && $thumbnail['size'] < 2_000_000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['edit-post'] = "Invalid image type or size too big.";
                header('location: ' . ROOT_URL . 'admin/edit_post.php');
                die();
            }
        }

        // Update is_featured for all posts if current post is featured
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Set thumbnail for query
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        // Execute update query
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION['edit-post-success'] = "Post updated successfully";
        } else {
            $_SESSION['edit-post'] = "Failed to update post.";
        }
    }

    // Redirect based on success or error
    header('location: ' . ROOT_URL . 'admin/');
    die();
}
?>
