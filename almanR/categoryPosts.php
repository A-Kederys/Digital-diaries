<?php
session_start();
include 'partials/header.php';

//getting posts if id is set
if(isset($_GET['cat_id']))
{
    $id = filter_var($_GET['cat_id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE cat_id=$id ORDER BY post_date DESC";
    $posts = mysqli_query($connection, $query);
}
else
{
    header('location: ' . ROOT_URL . 'posts.php');
    die();
}
?>
 <!-- CATEGORIES START -->
    <section class="catsButton lessMargin">
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

    <!-- CATEGORY TITLE START -->
    <header class="categoryTitle">
        <?php
            //getting category from categories table using cat_id
            $category_id = $id;
            $category_query = "SELECT * FROM categories WHERE cat_id=$category_id";
            $category_result = mysqli_query($connection, $category_query);
            $category = mysqli_fetch_assoc($category_result);
        ?>
        <h2><?= $category['cat_name'] ?></h2>
    </header>
    <!-- CATEGORY TITLE END -->

    <!-- POSTS START -->

    <?php if (mysqli_num_rows($posts) >0) : ?>
        <section class="posts">
            <div class="container postsContainer"> 
                <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                    <article class="post">
                        <div class="postImg">
                            <img src="./images/<?= $post['post_img'] ?>" alt="">
                        </div>
                        <div class="post">
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
                            </div>
                            <h3 class="postTitle"><a href="<?= ROOT_URL ?>post.php?post_id=<?= $post['post_id'] ?>"><?= $post['post_title'] ?></a></h3>
                            <p class="postDesc">
                                <?= substr($post['post_desc'], 0, 150) ?>
                            </p>
                            
                        </div>
                    </article>
                <?php endwhile ?>

            </div>
        </section>
    <?php else : ?>
        <img src="./images/notFound.gif" alt="" class = "notFoundImg">
    <?php endif ?>

    <!-- POSTS END -->

    <?php
        include 'partials/footer.php';
    ?>



</body>
</html>