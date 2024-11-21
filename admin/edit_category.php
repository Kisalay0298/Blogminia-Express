<?php
include 'partials/header.php';
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    //fetch category from database
    $query = "select * from categories where id=$id";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result)==1){
        $category = mysqli_fetch_assoc($result);
    }
}else{
    header('location:'.ROOT_URL.'admin/manage_categories.php');
    die();
}
?>

    <section class="form_section">
        <div class="container form_section_container">
            <h2>Edit Category</h2>
            <form action="<?= ROOT_URL ?>admin/edit_category_logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?php echo $category['description'] ?></textarea>
                <button type="submit" name="submit" class="btn">Update Category</button>
            </form>
        </div>
    </section>

<?php
include '../partials/footer.php';
?>