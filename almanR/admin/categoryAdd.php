<?php  
    session_start();
    include 'partials/header.php';

    //geting fields data if they were invalid
    $title = $_SESSION['add-category-data']['title'] ?? null;
    $description = $_SESSION['add-category-data']['description'] ?? null;

    unset($_SESSION['add-category-data']);
?>

    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <h2>Add a category</h2>
            <?php if(isset($_SESSION['add-category'])) : ?>
                <div class="msgAlert error">
                    <p>
                        <?= $_SESSION['add-category'];
                        unset($_SESSION['add-category']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/categoryAdd-logic.php" method="POST">
                <input type="text" value="<?= $title ?>" name="title" placeholder="Category name">
                <textarea rows="5" value="<?= $description ?>" name="description" placeholder="What category is about?"></textarea>
                <button type="submit" name="submit" class="signupButton">Add</button>
            </form>
        </div>  
    </section>

    <?php
        include '../partials/footer.php';
    ?>

  
</body>
</html>