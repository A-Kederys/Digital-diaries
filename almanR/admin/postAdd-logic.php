<?php
session_start();
require 'config/db.php';

if(isset($_POST['submit']))
{
    $blogger_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $isHot = filter_var($_POST['isHot'], FILTER_SANITIZE_NUMBER_INT);
    $thumb = $_FILES['thumb'];

    //setting isHot to 0 if unchecked
    $isHot = $isHot == 1 ?: 0;

    // validating form data
    if(!$title)
    {
        $_SESSION['add-post'] = "You must enter the post title!";
    }
    elseif(!$category_id)
    {
        $_SESSION['add-post'] = "Select the category";
    }
    elseif(!$body)
    {
        $_SESSION['add-post'] = "Write what your post is about";
    }
    elseif(!$thumb['name'])
    {
        $_SESSION['add-post'] = "Don't forget the photo!";
    }
    else
    {
        //renaming the image
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
                $_SESSION['add-post'] = "File is too big! (should be less than 2Mb";
            }
        }
        else
        {
            $_SESSION['add-post'] = "Photo should be .png, .jpg or .jpeg";
        }

    }
    //var_dump($thumb);

    //redirect back with the form data if there was any problem
    if(isset($_SESSION['add-post']))
    {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/postAdd.php');
        die();
    }
    else
    {
        //setting isHot of all posts to 0 if isHot for THIS post is 1
        if($isHot == 1)
        {
            $zero_all_isHot_query = "UPDATE posts SET is_hot=0";
            $zero_all_isHot_result = mysqli_query($connection, $zero_all_isHot_query);
        }

        //inserting post into db
        $query = "INSERT INTO posts (cat_id, blogger_id, post_title, post_desc, post_img, is_hot) 
                        VALUES ($category_id, $blogger_id, '$title', '$body', '$thumb_name', '$isHot')";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection))
        {
            $_SESSION['add-post'] = "Post couldn't be added";
        }
        else 
        {
            $_SESSION['add-post-success'] = "'$title' was added successfully";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
        //if(!mysqli_errno($connection))
        //{
            //$_SESSION['add-post-success'] = "'$title' was added successfully";
            //header('location: ' . ROOT_URL . 'admin/index.php');
            //die();
        //}
    }
}

header('location: ' . ROOT_URL . 'admin/postAdd.php');
die();

