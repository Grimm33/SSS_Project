<?php
session_start();

if(isset($_SESSION['email'])){
    if(isset($_POST['deleteUser'])){
        $userId = $_SESSION['userId'];
        $userImage = $_POST['image'];

        require_once('connect.php');
    
        if($conn){
            $queryDeleteUser = "DELETE FROM tbl_user WHERE userId = '$userId'";
            $resDelete = mysqli_query($conn, $queryDeleteUser);
            
            if(mysqli_affected_rows($conn) == 1){
                if($userImage != "./images/userImages/defaultUser.jpg"){
                    unlink($userImage);
                }
    
                unset($_SESSION['email']);
                unset($_SESSION['userId']);
            
                session_destroy();
                header("Location: index.php?user=removed");
            }else{
                $_SESSION['error'] = "errorRemovingUser";
                header("Location: index.php");
            }
        }
    }

}else{
    $_SESSION['error'] = "notLoggedIn";
    header("Location: index.php");
}
?>