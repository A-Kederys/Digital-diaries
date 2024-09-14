<?php
session_start();
require 'config/db.php';

if(isset($_GET['cat_id']))
{
    $id = filter_var($_GET['cat_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['cat_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //for later:
    //updating category cat_id of posts that belongs to that category of id of junk's category
    //if e.g. arts got deleted, then the posts will travel to "Junk" category
    $update_query = "UPDATE posts SET cat_id=15 WHERE cat_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection))
    {
        //deleting the category
        $query = "DELETE FROM categories WHERE cat_id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Category deleted succesfully";
    }
}

header('location: ' . ROOT_URL . 'admin/categoryManage.php');
die();
?>