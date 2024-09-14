<?php
session_start();
include 'partials/header.php';

//getting is_hot post from the db
$isHot_query = "SELECT * FROM posts where is_hot=1";
$isHot_result = mysqli_query($connection, $isHot_query);
$isHot = mysqli_fetch_assoc($isHot_result);

//getting posts from the db
$query = "SELECT * FROM posts ORDER BY RAND() DESC LIMIT 6";
$posts = mysqli_query($connection, $query);

?>


<!-- showing isHot post if there is one -->
<?php if(mysqli_num_rows($isHot_result) == 1) : ?>
    <!-- HOT START -->
    <section class="hot">
        <div class="container containerHot">
            <div class="hotPostImg">
                <img src="./images/<?= $isHot['post_img'] ?>">
            </div>
            <div class="post postHot">
                <div class="postPublisher">
                    <?php
                        //getting user from users using cat_id
                        $blogger_id = $isHot['blogger_id'];
                        $blogger_query = "SELECT * FROM users WHERE blogger_id=$blogger_id";
                        $blogger_result = mysqli_query($connection, $blogger_query);
                        $blogger = mysqli_fetch_assoc($blogger_result);
                    ?>
                    <div class="postPublisherImg">
                        <img src="./images/<?= $blogger['blogger_img'] ?>" alt="">
                    </div>
                    <div class="postPublisherInfo">
                        <h5><?= "{$blogger['blogger_name']} {$blogger['blogger_fname']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($isHot['post_date'])) ?></small>
                    </div>
                </div>
                <h2 class="postTitle"><a href="<?= ROOT_URL ?>post.php?post_id=<?= $isHot['post_id'] ?>"><?= $isHot['post_title'] ?></a></h2>
                <p class="postDescHot">
                    <?= $isHot['post_desc'] ?>
                </p>
                <?php
                    //getting category from categories table using cat_id
                    $category_id = $isHot['cat_id'];
                    $category_query = "SELECT * FROM categories WHERE cat_id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                ?>
                <a href="<?= ROOT_URL ?>categoryPosts.php?cat_id=<?= $category['cat_id'] ?>" class="catButton"><?= $category['cat_name'] ?></a>
                
            </div>
        </div>
        
    </section>
    <!-- HOT END -->
<?php endif ?>


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

    <!-- POSTS START -->

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
                        <?php
                            //getting category from categories table using cat_id
                            $category_id = $post['cat_id'];
                            $category_query = "SELECT * FROM categories WHERE cat_id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>categoryPosts.php?cat_id=<?= $post['cat_id'] ?>" class="catButton"><?= $category['cat_name'] ?></a>
                    </div>
                </article>
            <?php endwhile ?>

        </div>
    </section>

    <!-- POSTS END -->
    
    <?php
        include 'partials/footer.php';
    ?>
</body>
</html>