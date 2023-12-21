<?php
require 'enc.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
}

require 'db.php';
$db = new DB();

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

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/test.css">

    <title>Home</title>
</head>
<body>

<?php @include 'header.php'; ?>

<header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <h4 class="font-weight-bold mb-2">Categories:</h4>
                <ul id="collapseExample1" class="collapse show list-group list-group-flush">
                    <li class="list-group-item py-1">
                        <a href="home.php#products" style="text-decoration: none;" class="text-dark text-reset">All</a>
                    </li>
                    <?php

                        foreach($db->getCategories() as $category){
                            echo "
                            <li class='list-group-item py-1'>
                                <a style='text-decoration: none;' href='home.php?cat=" . $category['category'] . "#products' class='text-dark text-reset'>" . $category['category'] . "</a>
                            </li>
                            ";
                        }
                    ?>
                </ul>
                <h4 class="font-weight-bold mb-2">Price:</h4>
                <form action="" method="post">
                    <div class="range-slider">
                        <label for="customRange1" class="form-label">Min:</label>
                        <input name="min" type="range" value="<?php echo $db->getMinPrice(); ?>" min="<?php echo $db->getMinPrice(); ?>" max="<?php echo $db->getMaxPrice(); ?>" onmousemove="rangeSlider(this.value)">
                        <span id="rangeValue"><?php echo $db->getMinPrice(); ?></span>
                        <label for="customRange1" class="form-label">Max:</label>
                        <input name="max" type="range" value="<?php echo $db->getMaxPrice(); ?>" min="<?php echo $db->getMinPrice(); ?>" max="<?php echo $db->getMaxPrice(); ?>" onmousemove="rangeMax(this.value)">
                        <span id="rangeMax"><?php echo $db->getMaxPrice(); ?></span>
                        <div class="text-center">
                            <button name="submit" class="mt-2 btn btn-success" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</header>

<main>
    <section class="home">
        <div class="content">
            <h3>new products</h3>
            <p>You may buy them for a very low price in our shop without any fear of losing your money.</p>
            <a href="about.php?id=<?php echo encryptID($_SESSION['user_id'], "user_id"); ?>&page=1" class="btn btn-outline-light text-center font-weight-bold btn-lg mb-2">Discover More</a>
        </div>
    </section>
    <div class="container pt-4">
        <h1 class="text-center mt-3 mb-4" id="products">Latest Products</h1>
        <div class="row row-cols-3 g-3">
            <?php
                if(isset($_POST['submit'])){
                    if($_POST['min'] < $_POST['max']){
                        $products = $db->getProductBeyond($_POST['min'], $_POST['max']);
                    }
                } elseif (isset($_GET['cat'])){
                    $products = $db->getProductByCategory($_GET['cat']);
                } else {
                    $products = $db->getAll();
                }
                foreach($products as $product){
                    echo "
                        <div class='card mt-2 ml-2'>
                            <div id='like' class='d-flex justify-content-between p-3'>
                                <div class='rounded-circle d-flex align-items-center justify-content-center shadow-1-strong' style='width: 35px; height: 35px;'>
                                    <a href='like.php?id=" . encryptID($_SESSION['user_id'], "user_id") . "&pr_id=" . encryptID($product['id'], "pr_id") . "' class='text-dark'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                            <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z'/>
                                        </svg>
                                    </a>
                                </div>
                                <div class='bg-success rounded-circle d-flex align-items-center justify-content-center shadow-1-strong' style='width: 35px; height: 35px;'>
                                    <a href='view_more.php?id=" . encryptID($_SESSION['user_id'], "user_id") . "&pr_id=" . encryptID($product['id'], "pr_id") . "#users_comments' class='text-dark'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat' viewBox='0 0 16 16'>
                                            <path d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                        </svg>
                                    </a>
                                </div>
                            </div>";
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
                                    <a href='ins_card.php?id=" . encryptID($_SESSION['user_id'], "user_id") . "&pr_id=" . encryptID($product['id'], "pr_id") . "' class='btn btn-outline-primary font-weight-bold'><i class='fas fa-shopping-cart'></i></a>
                                </div>
                                <div class='d-flex justify-content-between ml-2 mb-2'>
                                    <a href='view_more.php?id=" . encryptID($_SESSION['user_id'], "user_id") . "&pr_id=" . encryptID($product['id'], "pr_id") . "' class='btn btn-outline-info font-weight-bold'><i class='fas fa-search-plus'></i></a>
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
</main>


<script>
    function rangeSlider(value){
        document.getElementById('rangeValue').innerHTML = value;
    }
    function rangeMax(value){
        document.getElementById('rangeMax').innerHTML = value;
    }
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>