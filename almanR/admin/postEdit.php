<?php
    session_start();
    include 'partials/header.php';

    //getting categories from db
    $category_query = "SELECT * FROM categories";
    $category_result = mysqli_query($connection, $category_query);


    //getting post data from db
    if(isset($_GET['post_id']))
    {
        $id = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM posts WHERE post_id=$id";
        $result = mysqli_query($connection, $query);
        $post = mysqli_fetch_assoc($result);
    }
    else
    {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }

?>

    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <h2>Edit a post</h2>
            <form action="<?= ROOT_URL ?>admin/postEdit-logic.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                <input type="hidden" name="previous_thumb_name" value="<?= $post['post_img'] ?>">
                <input type="text" name="title" value="<?= $post['post_title'] ?>" placeholder="What's the title?">
                <select name="category">
                    <?php while($category = mysqli_fetch_assoc($category_result)) : ?>
                    <option value="<?= $category['cat_id'] ?>"><?= $category['cat_name'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="8" name="body" placeholder="Describe it!"><?= $post['post_desc'] ?></textarea>
                <?php if(isset($_SESSION['user-is-admin'])) : ?>
                    <div class="formControl inline">
                        <input type="checkbox" name="isHot" value="1" id="isHot" checked>
                        <label for="isHot">Hot!</label>
                    </div>
                <?php endif ?>
                <div class="formControl">
                    <label for="thumb">Change an image!</label>
                    <input type="file" name="thumb" id="thumb">
                </div>
                <button type="submit" name="submit" class="signupButton">Edit</button>
            </form>
        </div>  
    </section>

    <?php
        include '../partials/footer.php';
    ?>
  
</body>
</html>