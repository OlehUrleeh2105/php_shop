<?php
require 'db.php';
require 'enc.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50 || !isset($_GET['order_num']) || strlen($_GET['order_num']) < 4 || strlen($_GET['order_num']) > 50) {
    header("location: index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getUserByID($userID);

if (!$db->userExist($user['email']) && !$db->isOrderExists(decryptID($_GET['order_num'], "order_num"))) {
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>View Order</title>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">Thanks for your order, <span style="color: rgba(16, 46, 46, 1);"><?php echo "" . $user['surname'] . " " . $user['name'] . ""; ?></span></h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0" style="color: rgba(16, 46, 46, 1);">Receipt</p>
                        </div>

                        <?php
                            $sum = 0;
                            foreach ($db->getOrdersByNum(decryptID($_GET['order_num'], "order_num")) as $order) {
                                $product = $db->getProductByID($order['product_id']);
                                $picture = scandir("uploaded_img/" . $product['id'], SCANDIR_SORT_DESCENDING)[0];
                                
                                $sum += ($product['price'] * $order['quantity']);
                                echo "
                                <div class='card shadow-0 border mb-4'>
                                    <div class='card-body'>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <img src='uploaded_img/" . $product['id'] . "/" . $picture . "' style='width: 81px; height: 54px;' class='img-fluid'>
                                            </div>
                                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                                <p class='text-muted mb-0'>" . $product['title'] . "</p>
                                            </div>
                                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                                <p class='text-muted mb-0 small'>" . $product['category'] . "</p>
                                            </div>
                                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                                <p class='text-muted mb-0 small'>Qty: " . $order['quantity'] . "</p>
                                            </div>
                                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                                <p class='text-muted mb-0 small'>$" . ($product['price'] * $order['quantity']) . "</p>
                                            </div>
                                        </div>
                                        <hr class='mb-4' style='background-color: #e0e0e0; opacity: 1;'>
                                        <div class='row d-flex align-items-center'>
                                            <div class='col-md-2'>
                                                <p class='text-muted mb-0 small'>Track Order</p>
                                            </div>
                                            <div class='col-md-10'>
                                                <div class='progress' style='height: 6px; border-radius: 16px;'>";
                                                    if($order['state'] == "placed"){
                                                        echo "<div class='progress-bar' role='progressbar'
                                                            style='width: " . rand(0, 35) . "%; border-radius: 16px; background-color: rgba(16, 46, 46, 1);' aria-valuenow='65'
                                                            aria-valuemin='0' aria-valuemax='100'></div>";
                                                    }
                                                    elseif($order['state'] == "in progress"){
                                                        echo "<div class='progress-bar' role='progressbar'
                                                            style='width: " . rand(40, 75) . "%; border-radius: 16px; background-color: rgba(16, 46, 46, 1);' aria-valuenow='65'
                                                            aria-valuemin='0' aria-valuemax='100'></div>";
                                                    }
                                                    elseif($order['state'] == "delivered"){
                                                        echo "<div class='progress-bar' role='progressbar'
                                                            style='width: 100%; border-radius: 16px; background-color: rgba(16, 46, 46, 1);' aria-valuenow='65'
                                                            aria-valuemin='0' aria-valuemax='100'></div>";
                                                    }
                                                    
                                                echo "</div>
                                                <div class='d-flex justify-content-around mb-1'>
                                                    <p class='text-muted mt-1 mb-0 small ms-xl-5'>Placed</p>
                                                    <p class='text-muted mt-1 mb-0 small ms-xl-5'>In progress</p>
                                                    <p class='text-muted mt-1 mb-0 small ms-xl-5'>Delivered</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }
                        ?>

                        <div class="d-flex justify-content-between pt-2">
                            <p class="fw-bold mb-0">Order Details</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> $<?php echo $sum; ?></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="text-muted mb-0">Tax: <?php echo $sum / 100; ?></p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Take care</span> about goverment</p>
                        </div> 

                        <div class="d-flex justify-content-between mb-5">
                            <p class="text-muted mb-0">Shipping: <?php echo $sum * 0.115; ?></p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery</span>is not free</p>
                        </div> 

                    </div>
                    <div class="card-footer border-0 px-4 py-5"
                        style="background-color: rgba(16, 46, 46, 1); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                            paid: <span class="h2 mb-0 ms-2">$<?php echo ($sum * 0.115) + $sum + ($sum / 100); ?></span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php @include 'footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>