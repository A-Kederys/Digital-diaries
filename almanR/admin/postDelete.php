<?php

session_start();
require 'config/db.php';

if(isset($_GET['post_id']))
{
    $id = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);

    //getting posts frm db in order to delete pic from the folder
    $query = "SELECT * FROM posts WHERE post_id=$id";
    $result = mysqli_query($connection, $query);

    //making sure we are deleting only 1 post
    if(mysqli_num_rows($result) == 1)
    {
        $post = mysqli_fetch_assoc($result);
        $thumb_name = $post['post_img'];
        $thumb_path = '../images/' . $thumb_name;

        if($thumb_path)
        {
            unlink($thumb_path);

            //deleting post from db
            $delete_post_query = "DELETE FROM posts WHERE post_id=$id";
            $delete_post_result = mysqli_query($connection, $delete_post_query);

            if(!mysqli_errno($connection))
            {
                $_SESSION['delete-post-success'] = "Post deletion successful";
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
?>