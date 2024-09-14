<?php
    session_start();
    include 'partials/header.php';

    //getting back form data (firstname, last name, email etc.), if there was an error
    $firstname = $_SESSION['add-user-data']['firstname'] ?? null; //Notice: Undefined index: signup-data
    $lastname = $_SESSION['add-user-data']['lastname'] ?? null;
    $username = $_SESSION['add-user-data']['username'] ?? null;
    $email = $_SESSION['add-user-data']['email'] ?? null;
    $createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
    $confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
    //deleting session data
    unset($_SESSION['add-user-data']);
?>

    <section class="sectionForm extraMargin">
        <div class="container sectionFormContainer">
            <h2>Add a new user</h2>
            <?php if (isset($_SESSION['add-user'])): ?>
                    <div class="msgAlert error">
                        <p>
                            <?= $_SESSION['add-user'];
                            unset($_SESSION['add-user']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/userAdd-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm password">
                <select name="userrole" value="<?= $userrole ?>">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
                <div class="formControl">
                    <label for="userAvatar">Choose the image</label>
                    <input type="file" name="userAvatar" id="userAvatar">
                </div>
                <button type="submit" name="submit" class="signupButton">Add</button>
            </form>
        </div>  
    </section>
    <?php
        include '../partials/footer.php';
    ?>
  
</body>
</html>