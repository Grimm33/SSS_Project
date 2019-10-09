<?php
session_start();

if(isset($_SESSION['email'])){
    require_once('connect.php');

    $email = $_SESSION['email'];
    $userId = $_SESSION['userId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Favourites</title>
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
        if($error == "ErrorRemoving"){
            ?>
            <div class="alert alert-danger text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                There was a problem removing your item. Please try again.
            </div>
            <?php
            unset($_SESSION['error']);
        }
    }

    if(isset($_SESSION['success'])){
        $success = $_SESSION['success'];
        if($success == "RemovedFave"){
            ?>            
            <div class="alert alert-primary text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Item Removed.
            </div>
            <?php
            unset($_SESSION['success']);
        }
    }


    if($conn){
        $queryGetUser = "SELECT name, surname FROM tbl_user WHERE email='$email'";
        $resUser = mysqli_query($conn, $queryGetUser);

        if(mysqli_affected_rows($conn) == 1){
            $rowUser = mysqli_fetch_array($resUser);
            ?>
            <h2>Favourites for <?php echo $rowUser[0] . " " . $rowUser[1]; ?></h2>
            <hr>
            <br>
            <?php
            
        }

        $queryGetFaves = "SELECT propertyId FROM tbl_favourite WHERE userId='$userId'";
        $resGetFaves = mysqli_query($conn, $queryGetFaves);
        
        if(mysqli_affected_rows($conn) > 0){
            while($rowFavesId = mysqli_fetch_array($resGetFaves)){
                $idToCheck = $rowFavesId['propertyId'];
                $queryGetProp = "SELECT * FROM tbl_property WHERE propertyId='$idToCheck'";
                $resGetProp = mysqli_query($conn, $queryGetProp);
                if(mysqli_affected_rows($conn) == 1){
                    $rowProp = mysqli_fetch_array($resGetProp);

                    $typeId = $rowProp['typeId'];
                    $townId = $rowProp['townId'];

                    $price = $rowProp['price'];
                    $image = $rowProp['image'];
                    $townName;
                    $typeName;

                    $queryGetTown = "SELECT town FROM tbl_town WHERE townId='$townId'";
                    $queryGetType = "SELECT type FROM tbl_type WHERE typeId='$typeId'";

                    $resGetTown = mysqli_query($conn, $queryGetTown);
                    if(mysqli_affected_rows($conn) == 1){
                        $rowTown = mysqli_fetch_array($resGetTown);
                        $townName = $rowTown[0];
                    }

                    $resGetType = mysqli_query($conn, $queryGetType);
                    if(mysqli_affected_rows($conn) == 1){
                        $rowType = mysqli_fetch_array($resGetType);
                        $typeName = $rowType[0];
                    }

                    ?>
                    <div class="card w-50 mx-auto">
                        <img src="<?php echo $image ?>" alt="Property Image" class="card-img-top">
                        <div class="card-body">
                            <h2><?php echo  ucfirst($typeName); ?> in <?php echo  ucfirst($townName); ?> - €<?php echo number_format($price) ?></h2>
                        </div>
                        <div class="card-footer text-center">
                            <form action="removeFave.php" method="post">
                                <input type="hidden" name="userId" value="<?php echo $userId ?>">
                                <input type="hidden" name="propId" value="<?php echo $idToCheck ?>">
                                <button class="btn btn-primary" name="removeFaveSub">Remove From Wishlist</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }

            }
        }else if(mysqli_affected_rows($conn) == 0){
            ?>
            <div class="alert alert-primary text-center" role="alert">
                No favourites. Please go on the homepage to add fvourites.
            </div>
            <?php
        }

    }else{
        ?>
        <div class="alert alert-danger text-center" role="alert">
            Error connecting to database.
        </div>
        <?php
    }
    ?>


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
}else{
    $_SESSION['error'] = "notLoggedIn";
    header("Location: index.php");
}
?>