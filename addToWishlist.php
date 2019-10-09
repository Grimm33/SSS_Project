<?php

session_start();

if(isset($_SESSION['email'])){
    if(isset($_POST['wishlistSub'])){
        $propertyId = $_POST['propId'];
        $userId = $_POST['userId'];
    
        require_once('connect.php');
        if($conn){
            $queryVerifyFave = "SELECT * FROM tbl_favourite WHERE userId='$userId' AND propertyId='$propertyId'";
            $resVerify = mysqli_query($conn, $queryVerifyFave);
    
            if(mysqli_num_rows($resVerify) == 0){
                $queryInsertFave = "INSERT INTO tbl_favourite (userId, propertyId) VALUES('$userId', '$propertyId')";
                $resFave = mysqli_query($conn, $queryInsertFave);
    
                if($resFave){
                    $_SESSION['success'] = "InsertingFave";
                    header("Location: index.php");
                }
                else{
                    $_SESSION['error'] = "ProblemInserting";
                    header("Location: index.php");
                }
            }else{
                $_SESSION['error'] = "FaveAlreadyExists";
                header("Location: index.php");
            }
        }
    }
}else{
    header("Location: index.php");
}
?>