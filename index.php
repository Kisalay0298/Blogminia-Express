<?php
include 'partials/header.php';

// fetch featured posts from database
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch only nine posts from the posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>

    <!-- show featured posts from database if there is any -->
    <?php if(mysqli_num_rows($featured_result)==1): ?>
        <section class="featured">
            <div class="container featured_cont">
                <div class="post_thumbnail">
                    <img src="./images/<?= $featured['thumbnail'] ?>" alt="blog1_img">
                </div>
                <div class="post_info">
                    <?php
                    //fetch category from categories table using category_id of post
                        $category_id = $featured['category_id'];
                        $category_query = "select * from categories where id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="<?= ROOT_URL ?>category_post.php?id=<?= $featured['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                    <h2 class="post_title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title']?></a>
                    </h2>
                    <p class="post_body">
                        <?= substr($featured['body'], 0, 300) ?>...
                    </p>
                    <div class="post_author">
                        <?php
                            // fetch author from users table using author_id
                            $author_id = $featured['author_id'];
                            $author_query = "SELECT * FROM users WHERE id=$author_id";
                            $author_result = mysqli_query($connection, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post_author_avatar">
                            <img src="./images/<?= $author['avatar'] ?>" alt="author_avatar">
                        </div>
                        <div class="post_author_info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif ?>


<!-- =========================== END OF FEATURED POST =========================== -->


    <section class="featured <?= $featured ? '' : 'section_extra_margin' ?>">
        <div class="container post_container">
            <?php while($post = mysqli_fetch_assoc($posts)): ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="blog2">
                    </div>
                    <div class="post_info">
                        <?php
                        //fetch category from categories table using category_id of post
                            $category_id = $post['category_id'];
                            $category_query = "select * from categories where id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category_post.php?id=<?= $post['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                        <h3 class="post_title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post_body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post_author">
                            <?php
                                // fetch author from users table using author_id
                                $author_id = $post['author_id'];
                                $author_query = "SELECT * FROM users WHERE id=$author_id";
                                $author_result = mysqli_query($connection, $author_query);
                                $author = mysqli_fetch_assoc($author_result);
                            ?>
                            <div class="post_author_avatar">
                                <img src="./images/<?= $author['avatar'] ?>">
                            </div>
                            <div class="post_author_info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small>
                                    <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>
        </div>
    </section>
    
<!-- =========================== END OF FEATURED POST =========================== -->


    <!-- section for selection option -->
    <section class="category_buttons">
        <div class="container category_buttons_container">
            <?php
            $all_categories_query = "select * from categories";
            $all_categories = mysqli_query($connection, $all_categories_query);
            ?>
            <?php while($category = mysqli_fetch_assoc($all_categories)): ?>
                <a href="<?= ROOT_URL ?>category_post.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
            <?php endwhile ?>
        </div>
    </section>


<?php
include 'partials/footer.php';
?>