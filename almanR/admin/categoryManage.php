<?php
    session_start();
    include 'partials/header.php';

    //getting categories from the db
    $query = "SELECT * FROM categories ORDER BY cat_name";
    $categories = mysqli_query($connection, $query);
?>

<section class="menu">
    <?php if (isset($_SESSION['add-category-success'])) : ?><!-- if add category was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-category'])) : ?><!-- if add category wasn't successful -->
        <div class="msgAlert error container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category'])) : ?><!-- if edit category wasn't successful -->
        <div class="msgAlert error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category-success'])) : ?><!-- if edit category was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-category-success'])) : ?><!-- if delete category was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container menuContainer ctg">
        <aside>
            <ul>
                <li><a href="postAdd.php"><i class="uil uil-pen"></i>
                    <h5>Add a Post</h5></a>
                </li>
                <li><a href="index.php"><i class="uil uil-pen"></i>
                    <h5>Manage a Post</h5></a>
                </li>
                <?php if(isset($_SESSION['user-is-admin'])) : ?>
                    <li><a href="userAdd.php"><i class="uil uil-pen"></i>
                        <h5>Add an User</h5></a>
                    </li>
                    <li><a href="userManage.php"><i class="uil uil-pen"></i>
                        <h5>Manage an User</h5></a>
                    </li>
                    <li><a href="categoryAdd.php"><i class="uil uil-pen"></i>
                        <h5>Add a Category</h5></a>
                    </li>
                    <li><a href="categoryManage.php" class="active"><i class="uil uil-pen"></i>
                        <h5>Manage a Category</h5></a>
                    </li>
                    <li><a href="usersPostsManage.php"><i class="uil uil-pen"></i>
                        <h5>Users posts</h5></a>
                    </li>
                <?php endif ?>
            </ul>

        </aside>
        <main>
            <h2>Manage a Category</h2>
            <?php if(mysqli_num_rows($categories) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?= $category['cat_name'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/categoryEdit.php?cat_id=<?= $category['cat_id'] ?>"><i class="uil uil-pen"></i></a></td>
                            <td><a href="<?= ROOT_URL ?>admin/categoryDelete.php?cat_id=<?= $category['cat_id'] ?>"><i class="uil uil-trash"></i></a></td>
                        </tr>
                    <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="msgAlert error" ><?= "No categories in the Database" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
    include '../partials/footer.php';
?>