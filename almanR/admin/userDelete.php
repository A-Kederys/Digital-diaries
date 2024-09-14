<?php
session_start();
require 'config/db.php';

if(isset($_GET['blogger_id']))
{
    //getting user from the db
    $id = filter_var($_GET['blogger_id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM users WHERE blogger_id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    //making sure 1 user was fetched (so we wont delete few people)
    if(mysqli_num_rows($result) == 1)
    {
        //var_dump($user);
        $avatar_name = $user['blogger_img'];
        $avatar_path = '../images/' . $avatar_name;
        //deleting image
        if($avatar_path)
        {
            unlink($avatar_path);
        }
    }

    //note for later: I will need to get and delete all of the user's posts photos
    $thumbnails_query = "SELECT post_img FROM posts WHERE blogger_id=$id";
    $thumbnails_result = mysqli_query($connection, $thumbnails_query);
    //making sure the user has at least one post
    if(mysqli_num_rows($thumbnails_result) > 0)
    {
        while($thumbnail = mysqli_fetch_assoc($thumbnails_result))
        {
            $thumbnail_path = '../images/' . $thumbnail['post_img'];
            //deleting it
            if($thumbnail_path)
            {
                unlink($thumbnail_path);
            }
        }
    }





    //deleting user details from db
    $delete_user_query = "DELETE FROM users WHERE blogger_id=$id";
    $delete_user_result = mysqli_query ($connection, $delete_user_query);
    if(mysqli_errno($connection))
    {
        $_SESSION['delete-user'] = "User {$user['blogger_name']} {$user['blogger_fname']} has some posts! ";
    }
    else
    {
        $_SESSION['delete-user-success'] = "{$user['blogger_name']} {$user['blogger_fname']} deleted successfully";
    }
}

header('location: ' . ROOT_URL . 'admin/userManage.php');
die();