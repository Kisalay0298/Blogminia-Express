<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // for later
    //update category_id of post that belong to this category to id of uncategorised category
    $update_query = "update posts set category_id=16 where category_id = $id";
    $update_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection)){
        // delete category
        $query = "delete from categories where id = $id limit 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Category deleted successfully";
    }
}

header('location: ' . ROOT_URL . 'admin/manage_categories.php');
die();

