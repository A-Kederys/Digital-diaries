<?php

session_start();
require 'config/db.php';

if(isset($_POST['submit']))
{
    //getting updated form data
    $id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumb_name = filter_var($_POST['previous_thumb_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $isHot = filter_var($_POST['isHot'], FILTER_SANITIZE_NUMBER_INT);
    $thumb = $_FILES['thumb'];

    //setting isHot to 0 if it was unchecked
    $isHot = $isHot == 1 ?: 0;

    //checking and validating input values
    if(!$title)
    {
        $_SESSION['edit-post'] = "Where's the title?";
    }
    if(!$category_id)
    {
        $_SESSION['edit-post'] = "Why there's no category?";
    }
    if(!$body)
    {
        $_SESSION['edit-post'] = "Leave a description!";
    }
    else
    {
        //deleting existing picture if the new one is available
        if($thumb['name'])
        {
            $previous_thumb_path = '../images/' . $previous_thumb_name;
            if($previous_thumb_path)
            {
                unlink($previous_thumb_path);
            }

            //working on new picture
            //renaming it
            $time = time(); // for uniqueness
            $thumb_name = $time . $thumb['name'];
            $thumb_tmp_name = $thumb['tmp_name'];
            //destination
            $thumb_destination_path = '../images/' . $thumb_name;

            //is file an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumb_name);
            //var_dump($extension);
            $extension = end($extension);

            if(in_array($extension, $allowed_files))
            {
                //size check
                if($thumb['size'] < 2000000)//2Mb
                {
                    //uploading the img
                    move_uploaded_file($thumb_tmp_name, $thumb_destination_path);
                }
                else
                {
                    $_SESSION['edit-post'] = "File is too big! (should be less than 2Mb";
                }
            } else {
                $_SESSION['edit-post'] = "Photo should be .png, .jpg or .jpeg";
            }
        }
    }

    if($_SESSION['edit-post'])
    {
        //redirecting to main page if the form was invalid
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        //setting isHot of all the posts to 0 if, for this post it is 1
        if($isHot == 1)
        {
            $zero_all_isHot_query = "UPDATE posts SET is_hot=0";
            $zero_all_isHot_result = mysqli_query($connection, $zero_all_isHot_query);
        }

        //setting picture name if the new one was uploaded (else keeping an old name)
        $thumb_to_insert = $thumb_name ?? $previous_thumb_name;

        //updating post
        $query = "UPDATE posts SET post_title='$title', post_desc='$body', post_img='$thumb_to_insert', 
        cat_id=$category_id, is_hot=$isHot WHERE post_id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if(!mysqli_errno($connection))
    {
        $_SESSION['edit-post-success'] = "Post updated successfully"; 
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();

?>