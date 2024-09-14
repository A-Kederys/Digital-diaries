<?php
session_start();
require 'config/db.php';

//get signup form data if the button was clicked
if(isset($_POST['submit']))
{
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);//to escape special chars, we sanitize them
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['userAvatar'];
    //echo $firstname, ' ', $lastname, ' ', $username, ' ', $email, ' ', $createpassword, ' ', $confirmpassword;
    //var_dump($avatar);

    //validate inputs
    if(!$firstname)
    {
        $_SESSION['signup'] = "Please enter your First Name";
    }
    elseif(!$lastname)
    {
        $_SESSION['signup'] = "Please enter your Last Name";
    }
    elseif(!$username)
    {
        $_SESSION['signup'] = "Please enter your username";
    }
    elseif(!$email)
    {
        $_SESSION['signup'] = "Please enter a valid Email";
    }
    elseif(strlen($createpassword) < 8 ||  strlen($confirmpassword) < 8)
    {
        $_SESSION['signup'] = "Password should be at least 8 characters!";
    }
    elseif(!$avatar['name'])
    {
        $_SESSION['signup'] = "Please add your avatar :)";
    }
    else
    {
        if($createpassword !== $confirmpassword) //do passwords match?
        {
            $_SESSION['signup'] = "Passwords do not match!";
        }
        else 
        {
            $hashed_pass = password_hash($createpassword, PASSWORD_DEFAULT);//hash one of the passwords, if both of them match
            //echo $hashed_pass;

            //check if username or email already exists in db
            $user_check_query = "SELECT * FROM users WHERE blogger_username = '$username' OR blogger_email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0)
            {
                $_SESSION['signup'] = "Username or Email already taken :(";
            }
            else //avatar
            {
                //renaming
                $time =  time();//takes time from 1970 01 01 in seconds
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;//profile pictures will go to images folder


                //is file an image?
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);//gives us name + extention(an array) png, jpg, jpeg, txt and etc.)
                $extention = end($extention);
                if(in_array($extention, $allowed_files))//is extention that user uploaded is in the allowed files?
                {
                    //checking for image size
                    if($avatar['size'] < 2000000) // 2 MB
                    {
                        //uploading image
                        move_uploaded_file($avatar_temp_name, $avatar_destination_path);
                    }
                    else
                    {
                        $_SESSION['signup'] = 'File size is too big! (Should be less than 2Mb)';
                    }
                }
                else
                {
                    $_SESSION['signup'] = 'File should contain png, jpg or jpeg extention!';
                }
            }
        }   
    }
    //echo time();
    //var_dump($avatar);

    //redirecting back to the signup page if there was any problem
    if(isset($_SESSION['signup']))
    {
        //passing form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }
    else
    {
        //inserting new user into db
        $insert_user_query = "INSERT INTO users (blogger_name, blogger_fname, blogger_username, blogger_email, blogger_pass, blogger_img, admin)
                                             VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_pass', '$avatar_name', 0)";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        
        if(!mysqli_errno($connection))
        {
            //if everything went well, redirecting to login page
            $_SESSION['signup-success'] = "Registration successful, you can login :)";
            header('location: ' . ROOT_URL . 'login.php');
            die();
        }
    }
}
else //if we are accessing the page without clicking the button (manually)
{
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
?>