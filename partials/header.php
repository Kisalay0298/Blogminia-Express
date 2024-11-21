<?php
require 'config/database.php';

//fetch current user from database
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "select avatar from users where id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogminia Express</title>
    <link rel="stylesheet" href="<?php echo ROOT_URL ?>css/style.css">
    <!-- icons cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- text font link -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap">
</head>
<body>
    <nav>
        <div class="container nav_container">
            <a href="<?php echo ROOT_URL ?>" class="nav_logo">Blogminia Express</a>
            <ul class="nav_items">
                <li><a href="<?php echo ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?php echo ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?php echo ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?php echo ROOT_URL ?>contact.php">Contact</a></li>
                
                <?php if(isset($_SESSION['user-id'])): ?>
                    <li class="nav_profile">
                        <div class="avatar">
                            <img src="<?php echo ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="profile_picture">
                        </div>
                        <ul>
                            <li><a href="<?php echo ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?php echo ROOT_URL ?>logout.php">log out</a></li>
                        </ul>
                    </li>
                    
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">Sign in</a></li>
                <?php endif ?>

            </ul>
            <button id="ope_nav_btn"><i class="uil uil-bars"></i></button>
            <button id="close_nav_btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>