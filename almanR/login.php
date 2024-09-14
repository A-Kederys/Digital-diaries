<?php
session_start();
require 'config/constants.php';

//getting back form data, if there was an error

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> almaNR </title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/scrollBar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body class = "loginC">

    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <a href="index.php"> <i class="takeBack uil uil-arrow-left">Take me back!</i></a>
            <h2>Sign in with existing account</h2>
            <?php if(isset($_SESSION['signup-success'])) : ?>
                <div class="msgAlert success">
                    <p>
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['signin'])) : ?>
                <div class="msgAlert error">
                        <p>
                            <?= $_SESSION['signin'];
                            unset($_SESSION['signin']);
                            ?>
                        </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>login-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Email or Username">
                <input type="password" name="password" value="<?= $password ?>" placeholder="Your password">
                <button type="submit" name="submit" class="signupButton">Sign In</button>
                <small>No account? <a href="signup.php">Sign Up!</a></small>
            </form>
        </div>  
    </section>
  
</body>
</html>