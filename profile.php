<?php
session_start();

if(isset($_SESSION['email'])){
    require_once('connect.php');
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>Profile</title>
    </head>
    <body>
        <?php
        include('nav.php');
        ?>
        <div class="container">
            <br>
            <?php

            if(isset($_SESSION['error'])){
                $error = $_SESSION['error'];
                if($error == "emailExists"){
                    ?>            
                    <div class="alert alert-danger text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Email is already in use. Please try logging in.
                    </div>
                    <?php
                    unset($_SESSION['error']);
                }
            }
            
            if(isset($_SESSION['changed'])){
                $items = $_SESSION['changed'];
                $changedItems = explode(',', $items);
                if(in_array('name', $changedItems)){
                    ?>
                    <div class="alert alert-primary text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have changed your name!
                    </div>
                    <?php
                }

                if(in_array('surname', $changedItems)){
                    ?>
                    <div class="alert alert-primary text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have changed your surname!
                    </div>
                    <?php
                }

                if(in_array('email', $changedItems)){
                    ?>
                    <div class="alert alert-primary text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have changed your email!
                    </div>
                    <?php
                }

                if(in_array('password', $changedItems)){
                    ?>
                    <div class="alert alert-primary text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have changed your password!
                    </div>
                    <?php
                }

                if(in_array('image', $changedItems)){
                    ?>
                    <div class="alert alert-primary text-center alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have changed your profile picture!
                    </div>
                    <?php
                }
                unset($_SESSION['changed']);
            }
            
            $email = $_SESSION['email'];

            $queryGetUser = "SELECT * FROM tbl_user WHERE email='$email'";
            $resGetUser = mysqli_query($conn, $queryGetUser);

            if(mysqli_num_rows($resGetUser) == 1){
                $rowUser = mysqli_fetch_array($resGetUser);

                $name = $rowUser['name'];
                $surname = $rowUser['surname'];
                $email = $rowUser['email'];
                $image = $rowUser['image'];
            }else{
                ?>
                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    There was a problem recovering your profile.
                </div>
                <?php
            }
            
            ?>

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <div class="row">

                        <div class="col-4">
                            <img src="<?php echo $image; ?>" alt="Profile Picture" class="img-thumbnail">
                        </div>
                        <div class="col-8">
                            <h2 class="display-4"><?php echo $email; ?>'s Profile</h2>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td><?php echo $name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Surname</th>
                                        <td><?php echo $surname; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2"></div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col text-center">
                        <form action="changeInfo.php" method="post">
                            <input type="hidden" name="fName" value="<?php echo $name; ?>">
                            <input type="hidden" name="lName" value="<?php echo $surname; ?>">
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                            <input type="hidden" name="image" value="<?php echo $image; ?>">
                            <button class="btn btn-primary" type="submit" name="changeUserInfo">Change Information</button>
                        </form>
                        </div>
                        <div class="col text-center">
                            <form action="deleteUser.php" method="post">
                                <input type="hidden" name="image" value="<?php echo $image; ?>">
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit" name="deleteUser" aria-describedby="buttonWarning">Delete User</button>
                                    <small class="form-text text-muted" id="buttonWarning">This will permanently delete your account!</small>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div> 
            <?php
            include('footer.html');
            ?>
        



        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
}else{
    $_SESSION['error'] = "notLoggedIn";
    header("Location: index.php");
}
?>
