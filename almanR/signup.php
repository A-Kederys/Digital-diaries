<?php
session_start();
require 'config/constants.php';


//getting back form data (firstname, last name, email etc.), if there was an error
$firstname = $_SESSION['signup-data']['firstname'] ?? null; //Notice: Undefined index: signup-data
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//ending the session
unset($_SESSION['signup-data']);
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
<body>

    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <a href="index.php"> <i class="takeBack uil uil-arrow-left">Take me back!</i></a>
            <h2>Sign up a new account</h2>
            <?php if (isset($_SESSION['signup'])): ?>
                    <div class="msgAlert error">
                        <p>
                            <?= $_SESSION['signup'];
                            unset($_SESSION['signup']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Your password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm your password">
                <div class="formControl">
                    <label for="userAvatar">Choose your image:</label>
                    <input type="file" name="userAvatar" id="userAvatar" placeholder="">
                </div>
                <button type="submit" name="submit" class="signupButton">Sign Up</button><!-- this will redirect to signup logic-->
                <small>Already have an account? <a href="login.php">Sign In!</a></small>
            </form>
        </div>  
    </section>
  
</body>
</html>