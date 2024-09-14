<?php
require 'config/db.php';
//getting user from db
if (isset($_SESSION['user-id']))
{
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT blogger_img FROM users WHERE blogger_id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> almanR </title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/scrollBar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <!-- NAV START -->
    <nav>
        <div class="container navBlock">
            <a href="<?= ROOT_URL ?>" class="logo">almanR</a>
            <ul class="items">
                <li><a href="<?= ROOT_URL ?>posts.php">Posts</a></li>
                <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="navMenu"> 
                        <div class="userImg">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['blogger_img'] ?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Menu</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>login.php">Login</a></li>
                <?php endif ?>
            </ul>
            <!--
            <button id="openButton"><i class="uil uil-bars"></i></button>
            <button id="closeButton"><i class="uil uil-multiply"></i></button>
            -->
        </div>     
    </nav>
    <!-- NAV END -->
</body>
</html>