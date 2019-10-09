<?php
if(isset($_POST['registerSub'])){
    $name = $_POST['firstName'];
    $surname = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['passwd'];
    $confPass = $_POST['passwdConf'];

    if(!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($confPass)){
        $name = ucfirst($name);
        $surname = ucfirst($surname);
        if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){

            $file_path = "images/userImages/" . $_FILES['image']['name'];

            $uploaded = move_uploaded_file($_FILES['image']['tmp_name'], $file_path);

            if($uploaded){
                if($password == $confPass){
                    
                require_once('connect.php');
        
                    $password = hash('sha256', $password);
        
                    if($conn){
                        $imageLink = "./images/defaultUser.jpg";
                        $queryCheckUser = "INSERT INTO tbl_user (email, password, name, surname, image) VALUES('$email', '$password', '$name', '$surname', '$file_path')";
                        $resCheckuser = mysqli_query($conn, $queryCheckUser);
        
                            if(mysqli_errno($conn) == 1062){
                                ?>
                                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    User already exists.
                                </div>
                                <?php
                            }else if(mysqli_error($conn)){
                                ?>
                                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    Error: <?php echo mysqli_error($conn); ?>
                                </div>
                                <?php
                            }else if (mysqli_affected_rows($conn) == 1) {
                                $queryGetUserId = "SELECT userId FROM tbl_user WHERE email='$email'";
                                $resUserId = mysqli_query($conn, $queryGetUserId);
                                $rowUSerId = mysqli_fetch_assoc($resUserId);
                                
                                $_SESSION['userId'] =$rowUSerId['userId'];
                                $_SESSION['email'] = $email;
                                header("Location: index.php");
                                                                
                            }else {
                                ?>
                                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    User not inserted.
                                </div>
                                <?php
                            }
                    }else{
                        ?>
                        <div class="alert alert-danger text-center alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Unable to connect to database. please try again later.
                        </div>
                        <?php
                    }
        
                }else{
                    ?>
                    <div class="alert alert-danger text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Passwords do not match!
                    </div>
                    <?php
                }

            }else{
                ?>
                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Error occured while uploading image. <?php echo $_FILES['image']['error'] ?>
                </div>
                <?php
            }
        }else{
            ?>
            <div class="alert alert-danger text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Please upload your profile image.
            </div>
            <?php
        }
    }else{
        ?>
        <div class="alert alert-danger text-center alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Please fill all inputs!
        </div>
        <?php
    }
}else{
    ?>
    <h4 class="text-center">Register</h4>
    <form action="LoginRegister.php" method="post" enctype="multipart/form-data">
        <div class="row text-center">
            <div class="col">
                <div class="form-group text-center">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control text-center" name="firstName" id="firstName" required placeholder="Enter First Name">
                </div>
            </div>
            <div class="col">
                <div class="form-group text-center">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control text-center" name="lName" id="lName" required placeholder="Enter Last Name">
                </div>
            </div>
        </div>
    
        <div class="form-group text-center">
            <label for="email">Email Address</label>
            <input type="email" class="form-control text-center" name="email" id="email" required placeholder="Enter Email Address">
        </div>
    
    
        <div class="row">
            <div class="col">
                <div class="form-group text-center">
                    <label for="passwd">Password</label>
                    <input type="password" class="form-control text-center" name="passwd" id="passwd" required placeholder="Enter Password">
                </div>
            </div>
            <div class="col">
                <div class="form-group text-center">
                    <label for="passwdConf">Confirm Password</label>
                    <input type="password" class="form-control text-center" name="passwdConf" id="passwdConf" required placeholder="Confirm Password">
                </div>
            </div>
        </div>
    
        <br>
    
        <div class="input-group text-center">
            <div class="input-group-prepend">
                <span class="input-group-text" id="imageAddon">Upload</span>
            </div>
            <div class="custom-file">
                <label for="imageUpload" class="custom-file-label">Choose Profile Picture</label>
                <input type="file" name="image" id="imageUpload" class="custom-file-input text-center" aria-describedby="imageAddon">
            </div>
        </div>
    
        <br>
    
        <div class="row">
            <div class="col text-center">
                <button class="btn btn-primary" type="submit" name="registerSub">Register</button>
            </div>
        </div>
    </form>
    <br>
    <hr>
    <br>
    <?php
}
?>