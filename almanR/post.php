<?php
session_start();
include 'partials/header.php';

//getting post from the db if id is set
if(isset($_GET['post_id']))
{
    $id = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE post_id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}
else
{
    header('location: ' . ROOT_URL . 'posts.php');
    die();
}
?>
    <!-- CATEGORIES START -->
    <section class="catsButton">
        <div class="container catsButtonContainer snapsInline">
            <?php
                $all_categories_query = "SELECT * FROM categories ORDER BY cat_id DESC";
                $all_categories_result = mysqli_query($connection, $all_categories_query);
            ?>
            <?php while($category = mysqli_fetch_assoc($all_categories_result)) : ?>
                <a href="<?= ROOT_URL ?>categoryPosts.php?cat_id=<?= $category['cat_id'] ?>" class="catButton"><?= $category['cat_name'] ?></a>
            <?php endwhile ?>
        </div>
    </section>
    <!-- CATEGORIES END -->

    <!-- SINGLE POST START -->
    <section class="singlePost">
        <div class="container singlePostContainer">
            <h2><?= $post['post_title'] ?></h2>
            <div class="postPublisher">
                <?php
                    //getting user from categories table using cat_id
                    $blogger_id = $post['blogger_id'];
                    $blogger_query = "SELECT * FROM users WHERE blogger_id=$blogger_id";
                    $blogger_result = mysqli_query($connection, $blogger_query);
                    $blogger = mysqli_fetch_assoc($blogger_result);
                ?>
                <div class="postPublisherImg">
                    <img src="./images/<?= $blogger['blogger_img'] ?>" alt="">
                </div>
                
                <div class="postPublisherInfo">
                    <h5><?= "{$blogger['blogger_name']} {$blogger['blogger_fname']}" ?></h5>
                    <small><?= date("M d, Y - H:i", strtotime($post['post_date'])) ?></small>
                </div>
                    <?php
                        //getting category from categories table using cat_id
                        $category_id = $post['cat_id'];
                        $category_query = "SELECT * FROM categories WHERE cat_id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                    ?>
                <a href="<?= ROOT_URL ?>categoryPosts.php?cat_id=<?= $post['cat_id'] ?>" class="catButton"><?= $category['cat_name'] ?></a>
            </div>
            <div class="singlePostImg">
                <img src="./images/<?= $post['post_img'] ?>" alt="">
            </div>
            <p class="spacing">
                <?= $post['post_desc'] ?>
            </p>
            
        </div>
    </section>
    <!-- SINGLE POST END -->
  

    <?php
        include 'partials/footer.php';
    ?>



</body>
</html>