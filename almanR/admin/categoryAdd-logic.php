<?php
session_start();
require 'config/db.php';

if(isset($_POST['submit']))
{
    //getting data from the form
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$title)
    {
        $_SESSION['add-category'] = "You forgot category name";
    }
    elseif(!$description)
    {
        $_SESSION['add-category'] = "Please write what category is about";
    }

    //redirecting back to the category page with inputted values when input was invalid
    if(isset($_SESSION['add-category']))
    {
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/categoryAdd.php');
        die();
    }
    //if everything went well
    else
    {
        $cat_check_query = "SELECT * FROM categories WHERE cat_name = '$title'";
        $cat_check_result = mysqli_query($connection, $cat_check_query);
        if(mysqli_num_rows($cat_check_result) > 0)
        {
            $_SESSION['add-category'] = "Category already exists! :(";
            header('location: ' . ROOT_URL . 'admin/categoryAdd.php');
            die();
        }
        else
        {
             //inserting the category into the db
            $query = "INSERT INTO categories (cat_name, cat_desc) VALUES ('$title', '$description')";
            $result = mysqli_query($connection, $query);
            if(mysqli_errno($connection))
            {
                $_SESSION['add-category'] = "Couldn't add the category";
                header('location: ' . ROOT_URL . 'admin/categoryAdd.php');
                die();
            }
            //if everything went well
            else
            {
                $_SESSION['add-category-success'] = "$title category was successfully added";
                header('location: ' . ROOT_URL . 'admin/categoryManage.php');
                die();
            }
        }

    }
}
?>