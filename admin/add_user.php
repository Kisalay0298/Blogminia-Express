<?php
include 'partials/header.php';

//get back form data if there was an error
$firstname = $_SESSION['add_user_data']['firstname'] ?? null;
$lastname = $_SESSION['add_user_data']['lastname'] ?? null;
$username = $_SESSION['add_user_data']['username'] ?? null;
$email = $_SESSION['add_user_data']['email'] ?? null;
$createpassword = $_SESSION['add_user_data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add_user_data']['confirmpassword'] ?? null;
// $userrole = $_SESSION['add_user_data']['userrole'] ?? null;

// delete session data
unset($_SESSION['add_user_data']);
?>



    <section class="form_section">
        <div class="container form_section_container">
            <h2>Add User</h2>
            <?php if(isset($_SESSION['add_user'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?php
                            echo $_SESSION['add_user'];
                            unset($_SESSION['add_user']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?php echo ROOT_URL ?>admin/add_user_logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?php echo $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?php echo $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?php echo $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?php echo $createpassword ?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?php echo $confirmpassword ?>" placeholder="Confirm Password">
                <select name="userrole">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <div class="form_control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Add User</button>
            </form>
        </div>
    </section>



<?php
include '../partials/footer.php';
?>
