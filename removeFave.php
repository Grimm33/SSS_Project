<?php
session_start();

if(isset($_SESSION['email'])){
    if(isset($_POST['removeFaveSub'])){
        require_once('connect.php');
    
        $userId = $_POST['userId'];
        $propId = $_POST['propId'];
        if($conn){
            $queryDelFave = "DELETE FROM tbl_favourite WHERE userId='$userId' AND propertyId='$propId'";
            $resDelete = mysqli_query($conn, $queryDelFave);

            if(mysqli_affected_rows($conn) == 1){
                $_SESSION['success'] = "RemovedFave";
                header("Location: favourites.php");
            }else{
                $_SESSION['error'] = "ErrorRemoving";
                header("Location: favourites.php");
            }
        }
    }
}else{
    $_SESSION['error'] = "notLoggedIn";
    header("Location: index.php");
}
?>