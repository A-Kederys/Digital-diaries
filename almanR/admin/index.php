<!-- postmanage -->
<?php
    session_start();
    include 'partials/header.php';

    //get current user's post from db
    $current_user_id = $_SESSION['user-id'];
    $query = "SELECT post_id, post_title, cat_id FROM posts WHERE blogger_id = $current_user_id ORDER BY post_id DESC";
    $posts = mysqli_query($connection, $query);
?>

<section class="menu">
    <?php if (isset($_SESSION['add-post-success'])) : ?><!-- if add post was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : ?><!-- if edit post was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : ?><!-- if edit post was not successful -->
        <div class="msgAlert error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : ?><!-- if delete post was successful -->
        <div class="msgAlert success container">
            <p>
                <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container menuContainer">
        <aside>
            <ul>
                <li><a href="postAdd.php"><i class="uil uil-pen"></i>
                    <h5>Add a Post</h5></a>
                </li>
                <li><a href="index.php" class="active"><i class="uil uil-pen"></i>
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
                    <li><a href="categoryManage.php"><i class="uil uil-pen"></i>
                        <h5>Manage a Category</h5></a>
                    </li>
                    <li><a href="usersPostsManage.php"><i class="uil uil-pen"></i>
                        <h5>Users posts</h5></a>
                    </li>
                <?php endif ?>
            </ul>

        </aside>
        <main>
            <h2>Manage a Post</h2>
            <?php if(mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Post Title</th>
                            <th>Post Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php
                            $category_id = $post['cat_id'];
                            $category_query = "SELECT cat_name FROM categories WHERE cat_id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td><?= $post['post_title'] ?></td>
                                <td><?= $category['cat_name'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/postEdit.php?post_id=<?= $post['post_id'] ?>"><i class="uil uil-pen"></i></a></td>
                                <td><a href="<?= ROOT_URL ?>admin/postDelete.php?post_id=<?= $post['post_id'] ?>"><i class="uil uil-trash"></i></a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="msgAlert error" ><?= "No created posts" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
    include '../partials/footer.php';
?>
