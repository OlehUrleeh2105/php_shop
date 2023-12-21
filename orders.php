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

    <title>Orders</title>
</head>
<body>

<?php @include 'header.php'; ?>

<!-- <section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #a8729a;">Anna</span>!</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0" style="color: #a8729a;">Receipt</p>
                            <p class="small text-muted mb-0">Receipt Voucher : 1KAU9-84UIL</p>
                        </div>
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/13.webp"
                                            class="img-fluid" alt="Phone">
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0">Samsung Galaxy</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">White</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Capacity: 64GB</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Qty: 1</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">$499</p>
                                    </div>
                                </div>
                                <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-2">
                                        <p class="text-muted mb-0 small">Track Order</p>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="progress" style="height: 6px; border-radius: 16px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: 65%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="65"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-around mb-1">
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Out for delivary</p>
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Delivered</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/1.webp"
                                            class="img-fluid" alt="Phone">
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0">iPad</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Pink rose</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Capacity: 32GB</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Qty: 1</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">$399</p>
                                    </div>
                                </div>
                                <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-2">
                                        <p class="text-muted mb-0 small">Track Order</p>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="progress" style="height: 6px; border-radius: 16px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: 20%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="20"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-around mb-1">
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Out for delivary</p>
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Delivered</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <p class="fw-bold mb-0">Order Details</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> $898.00</p>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <p class="text-muted mb-0">Invoice Number : 788152</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Discount</span> $19.00</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="text-muted mb-0">Invoice Date : 22 Dec,2019</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">GST 18%</span> 123</p>
                        </div>

                        <div class="d-flex justify-content-between mb-5">
                            <p class="text-muted mb-0">Recepits Voucher : 18KU-62IIK</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery Charges</span> Free</p>
                        </div>
                    </div>
                    <div class="card-footer border-0 px-4 py-5"
                        style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                            paid: <span class="h2 mb-0 ms-2">$1040</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<div class="container mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <div class="text-left">
                    <a href="orders.php?id=<?php echo $_GET['id'] ?>" class="<?php if(empty($_GET['state'])) { echo 'active'; } ?> btn btn-outline-success" style="border-radius: 20px; width: 110px;">All</a>
                    <a href="orders.php?id=<?php echo $_GET['id'] ?>&state=placed" class="<?php if(isset($_GET['state']) && $_GET['state'] == "placed") { echo 'active'; } ?> btn btn-outline-primary" style="border-radius: 20px; width: 110px;">Placed</a>
                    <a href="orders.php?id=<?php echo $_GET['id'] ?>&state=in%20progress" class="<?php if(isset($_GET['state']) && $_GET['state'] == "in progress") { echo 'active'; } ?> btn btn-outline-secondary" style="border-radius: 20px; width: 110px;">In progress</a>
                    <a href="orders.php?id=<?php echo $_GET['id'] ?>&state=delivered" class="<?php if(isset($_GET['state']) && $_GET['state'] == "delivered") { echo 'active'; } ?> btn btn-outline-info" style="border-radius: 20px; width: 110px;">Delivered</a>
                </div>
            </div>
        </div>
        <div class="row mb-3 ml-1">
            <?php
                if(isset($_GET['state'])){
                    $order_nums = $db->getAllOrderNumsByState($userID, $_GET['state']);
                } else {
                    $order_nums = $db->getAllOrderNums($userID);
                }

                foreach ($order_nums as $order_num) {
                    $orders = $db->getOrdersByNum($order_num['order_num']);
                    echo "
                    <div class='col-sm-3 mt-3'>
                        <div class='card' style='width: 220px;'>
                            <div class='card-body'>
                                <h5 class='card-title'>Order Number " . $order_num['order_num'] . "</h5>";
                    $product_count = 0;
                    foreach ($orders as $order) {
                        $product = $db->getProductByID($order['product_id']);
                        echo "
                                <p class='card-text'>" . $product['title'];
                        $product_count++;
                        if ($product_count >= 1) {
                            echo "...</p>";
                            break; 
                        } else {
                            echo "</p>";
                        }
                    }
                    echo "
                                <a href='view_more_order.php?id=" . $_GET['id'] . "&order_num=" . encryptID($order_num['order_num'], "order_num") . "' class='btn btn-primary btn-block'> <i class='fas fa-info me-2'></i> View More</a>
                            </div>
                        </div>
                    </div>
                    ";
                }
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>