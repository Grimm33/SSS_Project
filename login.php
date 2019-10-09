<?php
if(isset($_SESSION['email'])){
    ?>
    <br>
    <br>
    <br>
    <div class="alert alert-primary text-center" role="alert">
        You are already logged in!
    </div>
    <?php
}else{
?>

    <h4 class="text-center">Login</h4>
    <form action="LoginRegister.php" method="post">
        <div class="form-group text-center">
            <label for="email">Email Address</label>
            <input type="email" class="form-control text-center" name="email" id="email" required placeholder="Enter Email Address">
        </div>
        <div class="form-group text-center">
            <label for="passwd">Password</label>
            <input type="password" class="form-control text-center" name="passwd" id="passwd" required placeholder="Enter password">
        </div>
        <div class="row">
            <div class="col text-center">
                <button class="btn btn-primary" type="submit" name="loginSub">Login</button>
            </div>
        </div>
    </form>

    <?php
    if(isset($_POST['loginSub'])){
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];

        $passwd = hash('sha256', $passwd);
        require_once('connect.php');

        if($conn){
            $queryCheckUser = "SELECT * FROM tbl_user WHERE email='$email' AND password='$passwd'";
            $resCheckUser = mysqli_query($conn, $queryCheckUser);

            $rowUser = mysqli_fetch_row($resCheckUser);

            if(mysqli_num_rows($resCheckUser) == 1){
                $_SESSION['email'] = $email;
                $_SESSION['userId'] = $rowUser['0'];
                header("Location: index.php");
            }

        }
    }
}
?>