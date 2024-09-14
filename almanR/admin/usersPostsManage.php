<?php
    session_start();
    include 'partials/header.php';

    //get  users posts/cat and user info from db
    $current_user_id = $_SESSION['user-id'];
    $query = "SELECT posts.post_id, users.blogger_name, users.blogger_fname, posts.post_title, categories.cat_id, categories.cat_name
    FROM ((users INNER JOIN posts ON users.blogger_id=posts.blogger_id) 
        INNER JOIN categories ON posts.cat_id=categories.cat_id)
    WHERE posts.blogger_id <> $current_user_id 
    ORDER BY users.blogger_name";
    $name_posts = mysqli_query($connection, $query);
?>

<section class="menu">
    <?php if (isset($_SESSION['delete-post-success'])) : ?><!-- if delete user was successful -->
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
                    <li><a href="categoryManage.php"><i class="uil uil-pen"></i>
                        <h5>Manage a Category</h5></a>
                    </li>
                    <li><a href="usersPostsManage.php" class="active"><i class="uil uil-pen"></i>
                        <h5>Users posts</h5></a>
                    </li>
                <?php endif ?>
            </ul>

        </aside>
        <main>
            <h2>Users Posts</h2>
                <?php if(mysqli_num_rows($name_posts) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Post Creator</th>
                                <th>Post Title</th>
                                <th>Post Categry</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($post = mysqli_fetch_assoc($name_posts)) : ?>
                                <tr>
                                    <td><?= "{$post['blogger_name']} {$post['blogger_fname']}" ?></td>
                                    <td><?= $post['post_title'] ?></td>
                                    <td><?= $post['cat_name'] ?></td>
                                    <td><a href="<?= ROOT_URL ?>admin/userPostDelete.php?post_id=<?= $post['post_id'] ?>"><i class="uil uil-trash"></i></a></td>
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
