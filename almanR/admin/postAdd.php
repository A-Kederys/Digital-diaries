<?php
    session_start();
    include 'partials/header.php';

    //get categories from db
    $query = "SELECT * FROM categories";
    $categories = mysqli_query($connection, $query);

    //getting back form data if inputs were invalid
    $title = $_SESSION['add-post-data']['title'] ?? null;
    $body = $_SESSION['add-post-data']['body'] ?? null;

    //deleting form data session
    unset($_SESSION['add-post-data']);
?>


    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <h2>Add a post</h2>
            <?php if(isset($_SESSION['add-post'])) : ?>
                <div class="msgAlert error">
                    <p>
                        <?= $_SESSION['add-post'];
                        unset($_SESSION['add-post']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/postAdd-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="What's the title?">
                <select name="category">
                    <?php while($category = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?= $category['cat_id'] ?>"><?= $category['cat_name'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="8" name="body" placeholder="Describe it!"><?= $body ?></textarea>
                <?php if(isset($_SESSION['user-is-admin'])) : ?>
                    <div class="formControl inline">
                        <input type="checkbox" name="isHot" value="1" id="isHot" checked>
                        <label for="isHot">Hot!</label>
                    </div>
                <?php endif ?>
                <div class="formControl">
                    <label for="thumb">Add an image!</label>
                    <input type="file" name="thumb" id="thumb">
                </div>
                <button type="submit" name="submit" class="signupButton">Add</button>
            </form>
        </div>  
    </section>

    <?php
        include '../partials/footer.php';
    ?>

  
</body>
</html>