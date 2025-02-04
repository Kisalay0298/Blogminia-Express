<?php

require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);


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
            <h2>Sign In</h2>
            

            <!-- i want this message to be pop up only after successfull registration -->
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert_message success">
                    <p>
                        <?php 
                            echo $_SESSION['signup-success'];
                            unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['signin'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?php 
                            echo $_SESSION['signin'];
                            unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?php echo ROOT_URL?>signin-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
                <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>
</body>
</html>