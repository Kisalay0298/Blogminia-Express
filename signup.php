<?php
// session_start(); // we dont need to start the session every single time
// we have passed the "start session" in the constants
require 'config/constants.php';


//get back form data in the signup page if there is anything mismatch or error in the new sign in page
$firstname = $_SESSION['signup-data']['firstname'] ?? null; //if you r not getting any data return null
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

//once we get everything delete everything also session
unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogminia with Admin Panel</title>
    <link rel="stylesheet" href="<?php echo ROOT_URL?>css/style.css">
    <!-- icons cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- text font link -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap">
</head>
<body>

    <section class="form_section">
        <div class="container form_section_container">
            <h2>Sign Up</h2>
            <?php if (isset($_SESSION['signup'])): ?> 
                <div class="alert_message error">
                    <p>
                        <?php 
                            echo $_SESSION['signup'];
                            unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>

            <?php endif ?>
            <form action="<?php echo ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="post">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
                <div class="form_control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
</body>