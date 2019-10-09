<?php
session_start();
require_once('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Home</title>
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
        if($error == "ProblemInserting"){
            ?>            
            <div class="alert alert-danger text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                There was a problem inserting your item. Please try again.
            </div>
            <?php
            unset($_SESSION['error']);
        }else if($error == "FaveAlreadyExists"){
            ?>            
            <div class="alert alert-danger text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                This item already exists in your favourites!
            </div>
            <?php
            unset($_SESSION['error']);
        }else if($error == "errorRemovingUser"){
            ?>            
            <div class="alert alert-danger text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Error removing user. Please try again.
            </div>
            <?php
            unset($_SESSION['error']);
        }
    }
    
    if(isset($_SESSION['success'])){
        $success = $_SESSION['success'];
        if($success == "InsertingFave"){
            ?>
            <div class="alert alert-primary text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Success inserting item in favourites.
            </div>
            <?php
            unset($_SESSION['success']);
        }
    }

    if(isset($_GET['user'])){
        if($_GET['user'] == "removed"){
            ?>
            <div class="alert alert-primary text-center alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                User removed.
            </div>
            <?php
        }
    }

    include('search.html');
    ?>

<?php
if(isset($_POST['searchForm'])){
    $typeId = $_POST['type'];
    $locationId = $_POST['location'];
    $minPrice = $_POST['minMoney'];
    $maxPrice = $_POST['maxMoney'];

    if(!empty($typeId) && !empty($locationId) && !empty($minPrice) && !empty($maxPrice)){

        if($conn){
            $queryGetProp = "SELECT * FROM tbl_property WHERE typeId='$typeId' AND townId='$locationId' AND price BETWEEN '$minPrice' AND '$maxPrice'";
            $resProp = mysqli_query($conn, $queryGetProp);

            if(mysqli_affected_rows($conn) == 1){
                while($rowProp = mysqli_fetch_assoc($resProp)){
                    $queryGetType = "SELECT type FROM tbl_type WHERE typeId='$typeId'";
                    $queryGetLocation = "SELECT town FROM tbl_town WHERE townId='$locationId'";

                    $resType = mysqli_query($conn, $queryGetType);
                    $resLoc = mysqli_query($conn, $queryGetLocation);

                    $rowType = mysqli_fetch_array($resType);
                    $rowLoc = mysqli_fetch_array($resLoc);

                    ?>
                    <hr>
                    <h1 class="text-center">Properties</h1>
                    <br>
                    <div class="card w-50 mx-auto">
                        <img src="<?php echo $rowProp['image']; ?>" alt="Property Image" class="card-img-top">
                        <div class="card-body">
                            <h2><?php echo  ucfirst($rowType['type']); ?> in <?php echo  ucfirst($rowLoc['town']); ?> - €<?php echo number_format($rowProp['price']) ?></h2>
                        </div>
                        <div class="card-footer text-center">
                            <?php
                            if(isset($_SESSION['email'])){
                                ?>
                                <form action="addToWishlist.php" method="post">
                                    <input type="hidden" name="propId" value=" <?php echo $rowProp['propertyId']; ?> ">
                                    <input type="hidden" name="userId" value=" <?php echo $_SESSION['userId'] ?> ">
                                    <div class="col">
                                        <div class="row">
                                            <button class="btn btn-primary" name="wishlistSub">Add to wishlist</button> 
                                        </div>
                                    </div>
                                </form> 
                                <?php
                            }else{
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <a href="LoginRegister.php" class="btn btn-primary">Register</a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }else{
                ?>
                <div class="alert alert-warning text-center" role="alert">No Properties found. Please try searching again.</div>
                <?php
            }
        }else{
            ?>
            <div class="alert alert-danger text-center" role="alert">Error connecting to database. Please try again later.</div>
            <?php
        }
    }else{
        ?>
        <div class="alert alert-danger text-center" role="alert">Please fill all inputs!</div>
        <?php
    }
}
?>

    

    </div> 

    <?php
    include('footer.html');
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>