<?php
    session_start();
    include 'partials/header.php';

    if(isset($_GET['blogger_id']))
    {
        $id = filter_var($_GET['blogger_id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM users WHERE blogger_id=$id";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
    }
    /* 
    else
    {
        header('location: ' . ROOT_URL . 'admin/userManage.php');
        die();
    }
     */
?>

    <section class="sectionForm">
        <div class="container sectionFormContainer">
            <h2>Edit an existing user</h2>
            <form action="<?= ROOT_URL ?>admin/userEdit-logic.php" method="POST">
                <input type="hidden" value="<?= $user['blogger_id'] ?>" name="blogger_id" placeholder="First Name">
                <input type="text" value="<?= $user['blogger_name'] ?>" name="firstname" placeholder="First Name">
                <input type="text" value="<?= $user['blogger_fname'] ?>" name="lastname" placeholder="Last Name"> 
                <select name="userrole">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
                <button type="submit" name="submit" class="signupButton">Edit</button>
            </form>
        </div>  
    </section>

    <?php
        include '../partials/footer.php';
    ?>
  
</body>
</html>