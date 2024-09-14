<?php
session_start();
require 'config/db.php';

if(isset($_POST['submit'])) 
{
    //get login form data if the button was clicked
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //validate inputs
    if (!$username_email) {
        $_SESSION['signin'] = "You forgot to enter your Email or Username";
    } elseif (!$password) {
        $_SESSION['signin'] = "You forgot to enter your Password";
    } else 
    {
        //getting inputs from db
        $fetch_user_query = "SELECT * FROM users WHERE blogger_username = '$username_email' OR blogger_email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) //if it got exactly 1 user back 
        {
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['blogger_pass'];//getting hashed pass from db
            //comparing inputs password to db's password
            if (password_verify($password, $db_password))
            {
                //setting session for access control
                $_SESSION['user-id'] = $user_record['blogger_id'];
                //checking if he's an admin and setting him a session
                if ($user_record['admin'] == 1) 
                {
                    $_SESSION['user-is-admin'] = true;
                }
                //log user(admin) in
                header('location: ' . ROOT_URL . 'admin/');
            }
            else
            {
                $_SESSION['signin'] = "Wrong password!";
            }
        }
        else
        {
            $_SESSION['signin'] = "User not found ;(";
        }      
    }
    //if there was any problem, then redirecting user back to the login page with login data
    if (isset($_SESSION['signin']))
    {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'login.php');
        die();
    }
}
//if we are accessing the page without clicking the button (manually)
else 
{
    header('location: ' . ROOT_URL . 'login.php');
    die();
}
