<?php
session_start();

require 'config/db.php';

if(isset($_POST['submit']))
{
    $id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['cat_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['cat_desc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //validating inputs that we get
    if(!$title)
    {
        $_SESSION['edit-category'] = "Where's the title?";
    }
    elseif(!$description)
    {
        $_SESSION['edit-category'] = "Where's the description?";
    }

    else
    {
        $cat_check_query = "SELECT * FROM categories WHERE cat_name = '$title'";
        $cat_check_result = mysqli_query($connection, $cat_check_query);
        if(mysqli_num_rows($cat_check_result) > 0)
        {
            $_SESSION['edit-category'] = "Category already exists! :(";
        }
        else
        {
            $query = "UPDATE categories SET cat_name='$title', cat_desc='$description' WHERE cat_id='$id LIMIT 1'";
            $result = mysqli_query($connection, $query);

            if(mysqli_errno($connection))
            {
                $_SESSION['edit-category'] = "Category couldn't be updated";
            }
            else 
            {
                $_SESSION['edit-category-success'] = "$title successfully updated";
            }

        }
    }
}

header('location: ' . ROOT_URL . 'admin/categoryManage.php');
die();

?>