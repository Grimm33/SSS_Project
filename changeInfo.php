<?php
session_start();

$oldName;
$oldSurname;
$oldEmail;
$oldImage;

if(isset($_SESSION['email'])){
    if(isset($_POST['changeUserInfo'])){
        $oldName = $_POST['fName'];
        $oldSurname = $_POST['lName'];
        $oldEmail = $_POST['email'];
        $oldImage = $_POST['image'];

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

            <title>Change Information</title>
        </head>
        <body>
            <?php
            include('nav.php');
            ?>
            
            <div class="container">
                <br>

                <div class="row">
                    <div class="col">
                        <h3 class="display-5 text-center">Current Information</h3>
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td><?php echo $oldName; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Surname</th>
                                    <td><?php echo $oldSurname; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?php echo $oldEmail; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Image</th>
                                    <td>
                                        <img src="<?php echo $oldImage; ?>" alt="Profile Picture" class="img-thumbnail">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                        <h3 class="display-5 text-center" aria-describedby="newMessage">New Information</h3>
                        <small class="form-text text-muted text-center" id="newMessage">Anything you leave empty will be unchanged</small>
                        <table class="table table-hover">
                            <form action="changeInfo.php" method="post" enctype="multipart/form-data">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td><input type="text" class="form-control" name="newName"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Surname</th>
                                        <td><input type="text" class="form-control" name="newSurname"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><input type="text" class="form-control" name="newEmail"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Password</th>
                                        <td><input type="text" class="form-control" name="newPassword"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Image</th>
                                        <td>
                                            <div class="input-group text-center">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="imageAddon">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <label for="imageUpload" class="custom-file-label">Choose Profile Picture</label>
                                                    <input type="file" name="newImage" id="imageUpload" class="custom-file-input text-center" aria-describedby="imageAddon">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                                <div class="row">
                                    <div class="col text-center">
                                        <input type="hidden" name="oldImage" value="<?php echo $oldImage; ?>">
                                        <button class="btn btn-primary" type="submit" name="changeActual">Change</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>

                <?php
                include('footer.html');
                ?>
                
            </div> 


                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </body>
        </html>
        <?php


    }else if(isset($_POST['changeActual'])){
        $_SESSION['changed'] = "";
        require_once('connect.php');

        if($conn){
            $newName = $_POST['newName'];
            $newSurname = $_POST['newSurname'];
            $newEmail = $_POST['newEmail'];
            $newPassword = $_POST['newPassword'];
            $prevImage = $_POST['oldImage'];
            $userId = $_SESSION['userId'];
    
            if(!empty($newName)){
                $queryChangeName = "UPDATE tbl_user SET name='$newName' WHERE userId = '$userId'";
                mysqli_query($conn, $queryChangeName);
                $_SESSION['changed'] .="name,";
            }
    
            if(!empty($newSurname)){
                $queryChangeSurname = "UPDATE tbl_user SET surname='$newSurname' WHERE userId = '$userId'";
                mysqli_query($conn, $queryChangeSurname);
                $_SESSION['changed'] .="surname,";
            }
    
            if(!empty($newEmail)){
                $queryChangeEmail = "UPDATE tbl_user SET email='$newEmail' WHERE userId = '$userId'";
                mysqli_query($conn, $queryChangeEmail);
                if(mysqli_errno($conn) == 1062){
                    $_SESSION['error'] = "emailExists";
                    header("Location: profile.php");
                }else{
                    $_SESSION['email'] = $newEmail;
                    $_SESSION['changed'] .="email,";
                }

            }
            
            if(!empty($newPassword)){
                $newPassword = hash('sha256', $newPassword);
                $queryChangePassword = "UPDATE tbl_user SET password='$newPassword' WHERE userId = '$userId'";
                mysqli_query($conn, $queryChangePassword);
                $_SESSION['changed'] .="password,";
            }
            
            if(isset($_FILES['newImage']) && $_FILES['newImage']['size'] > 0){

                if($prevImage != "./images/userImages/defaultUser.jpg"){
                    unlink($prevImage);
                }

                $filePath = "images/userImages/" . $_FILES['newImage']['name'];
                $uploaded = move_uploaded_file($_FILES['newImage']['tmp_name'], $filePath);
                
                if($uploaded){
                    $updateImage = "UPDATE tbl_user SET image='$filePath' WHERE userId = '$userId'";
                    mysqli_query($conn, $updateImage);
                    $_SESSION['changed'] .="image,";
                }
            }else{
                print_r($_FILES);
            }
            header("Location: profile.php");
        }
    }
}else{
    $_SESSION['error'] = "notLoggedIn";
    header("Location: index.php");
}
?>