<?php
    session_start();
    include 'partials/header.php';

    if(isset($_GET['cat_id']))
    {
        $id = filter_var($_GET['cat_id'], FILTER_SANITIZE_NUMBER_INT);

        //getting category from the db
        $query = "SELECT * FROM categories WHERE cat_id=$id";
        $result = mysqli_query($connection, $query);

        //check if we are getting exactly 1 category
        if(mysqli_num_rows($result) == 1)
        {
            $category = mysqli_fetch_assoc($result);
        }

    }
    else
    {
        header('location: ' . ROOT_URL . 'admin/categoryManage.php');
        die();
    }
?>
    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <h2>Edit an existing category</h2>
            <form action="<?= ROOT_URL ?>admin/categoryEdit-logic.php" method="POST">
                <input type="hidden" name="cat_id" value="<?= $category['cat_id']?>">
                <input type="text" name="cat_name" value="<?= $category['cat_name']?>" placeholder="Category name">
                <textarea rows="5" name="cat_desc" placeholder="What category is about?"><?= $category['cat_desc']?></textarea>
                <button type="submit" name="submit" class="signupButton">Edit</button>
            </form>
        </div>  
    </section>

    <?php
        include '../partials/footer.php';
    ?>
  
</body>
</html>