<?php
    require 'db.php';
    require 'enc.php';
    
    $db = new DB();
    
    if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
        header("location: index.php");
        exit();
    }
    
    $userID = decryptID($_GET['id'], "user_id");
    $user = $db->getUserByID($userID);
    
    if (!$db->userExist($user['email'])) {
        header("location: index.php");
        exit();
    }    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Whish List</title>
</head>
<body>
    

<?php @include 'header.php'; ?>


    <div class="container">
        <div class="text-center mt-4">
            <h1 class="display-4 mb-3 font-weight-bold text-danger">Whish List</h1>
        </div>
        <div class="row row-cols-3 g-3">
            <?php
            
                $products = $db->getProductsLiked($userID);

                for ($i = 0; $i < count($products); $i++) {
                    $product = $db->getProductByID($products[$i]['product_id']);

                    echo "
                    <div class='card mt-2 ml-2'>
                                ";
                    $picture = scandir("uploaded_img/" . $product['id'], SCANDIR_SORT_DESCENDING)[0];
                    echo "
                        <img src='uploaded_img/" . $product['id'] . "/" . $picture . "' style='width: 348px; height: 232px;' class='card-img-top'/>";
                    echo "
                        <div class='card-body'>
                            <div class='d-flex justify-content-between mb-3'>
                                <h5 class='mb-0'>" . $product['title'] . "</h5>
                                <h5 class='text-dark mb-0'>$" . $product['price'] . "</h5>
                            </div>";
                    echo "
                            <div class='d-flex align-items-center justify-content-center'>
                                <div class='d-flex justify-content-between mb-2'>
                                    <a href='ins_card.php?id=" . $_GET['id'] . "&pr_id=" . encryptID($product['id'], "pr_id") . "' class='btn btn-outline-primary font-weight-bold'><i class='fas fa-shopping-cart'></i></a>
                                </div>
                                <div class='d-flex justify-content-between ml-2 mb-2'>
                                    <a href='view_more.php?id=" . $_GET['id'] . "&pr_id=" . encryptID($product['id'], "pr_id") . "' class='btn btn-outline-info font-weight-bold'><i class='fas fa-search-plus'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
                }
            ?>
        </div>
    </div>


<?php @include 'footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>