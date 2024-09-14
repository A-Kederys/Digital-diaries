<?php
session_start();
require 'config/db.php';
//was it clicked
if(isset($_POST['submit']))
{
    //get updated form data
    $id = filter_var($_POST['blogger_id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    //check if inputs are valid
    if(!$firstname || !$lastname)
    {
        $_SESSION['edit-user'] = "Invalid inputs";
    }
    else {
        //updating user
        $query = "UPDATE users SET blogger_name='$firstname', blogger_fname='$lastname', admin=$is_admin WHERE blogger_id=$id LIMIT 1";//LIMIT for updating only one user, just a safety precaution
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection))
        {
            $_SESSION['edit-user'] = "User update failed";
        }
        elseif(!mysqli_errno($connection)) 
        {
            $_SESSION['edit-user-success'] = "User '$firstname' '$lastname' updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/userManage.php');
die();