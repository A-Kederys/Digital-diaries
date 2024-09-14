<?php
    session_start();
    include 'partials/header.php';

    //getting users from db, except us
    $current_admin_id = $_SESSION['user-id'];

    $query = "SELECT * FROM users WHERE NOT blogger_id=$current_admin_id";
    $users = mysqli_query($connection, $query);
?>

<section class="menu">
            <?php if (isset($_SESSION['add-user-success'])) : ?><!-- if add user was successful -->
                <div class="msgAlert success container">
                    <p>
                        <?= $_SESSION['add-user-success'];
                        unset($_SESSION['add-user-success']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['edit-user-success'])) : ?><!-- if edit user was successful -->
                <div class="msgAlert success container">
                    <p>
                        <?= $_SESSION['edit-user-success'];
                        unset($_SESSION['edit-user-success']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['edit-user'])) : ?><!-- if edit user failed-->
                <div class="msgAlert error container">
                    <p>
                        <?= $_SESSION['edit-user'];
                        unset($_SESSION['edit-user']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['delete-user'])) : ?><!-- if delete user failed-->
                <div class="msgAlert error container">
                    <p>
                        <?= $_SESSION['delete-user'];
                        unset($_SESSION['delete-user']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['delete-user-success'])) : ?><!-- if delete user succeeded-->
                <div class="msgAlert success container">
                    <p>
                        <?= $_SESSION['delete-user-success'];
                        unset($_SESSION['delete-user-success']);
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
                    <li>
                        <a href="userAdd.php"><i class="uil uil-pen"></i>
                        <h5>Add an User</h5></a>
                    </li>
                    <li>
                        <a href="userManage.php" class="active"><i class="uil uil-pen"></i>
                        <h5>Manage an User</h5></a>
                    </li>
                    <li>
                        <a href="categoryAdd.php"><i class="uil uil-pen"></i>
                        <h5>Add a Category</h5></a>
                    </li>
                    <li>
                        <a href="categoryManage.php"><i class="uil uil-pen"></i>
                        <h5>Manage a Category</h5></a>
                    </li>
                    <li><a href="usersPostsManage.php"><i class="uil uil-pen"></i>
                        <h5>Users posts</h5></a>
                    </li>
                <?php endif ?>
            </ul>

        </aside>
        <main>
            <h2>Manage an User</h2>
            <?php if(mysqli_num_rows($users) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($users)) : ?>
                            <tr>
                                <td><?= "{$user['blogger_name']} {$user['blogger_fname']}" ?></td>
                                <td><?= $user['blogger_username'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/userEdit.php?blogger_id=<?= $user['blogger_id'] ?>"><i class="uil uil-pen"></i></a></td>
                                <td><a href="<?= ROOT_URL ?>admin/userDelete.php?blogger_id=<?= $user['blogger_id'] ?>"><i class="uil uil-trash"></i></a></td>
                                <td><?= $user['admin'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endwhile ?>
                        
                    </tbody>
                </table>
            <?php else : ?>
                <div class="msgAlert error" ><?= "No users in the Database" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
    include '../partials/footer.php';
?>
