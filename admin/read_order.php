<?php
require '../db.php';
require '../enc.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getAdminByID($userID);

if (!$db->userExist($user['email'])) {
    header("location: ../index.php");
    exit();
}

if(isset($_GET['state']) && isset($_GET['pr_id'])){
    if($db->updateState(decryptID($_GET['order_num'], "order_num"), $userID, $_GET['state'], decryptID($_GET['pr_id'], "pr_id"))){
        header("location: read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num']);
        exit();
    }
}


?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm_style.css">

    <title>Products</title>
</head>
<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>

    <?php @include 'header.php'; ?>

    <main class="page-content">
        <div class="container">
            <?php
            $orders = $db->getOrderByNum(decryptID($_GET['order_num'], "order_num"), $userID);

            echo "
                <div class='text-center mb-3'>
                    <h1>Order №" . decryptID($_GET['order_num'], "order_num") . "</h1>
                </div>
            ";

            echo "
                <div class='h4 mb-3'>
                    Order of <span class='text-weight-bold'>" . $orders[0]['name'] . " " . $orders[0]['surname'] . "</span>
                </div>
            ";

            echo "
                <div class='d-flex justify-content-between mb-3'>
                    <p class='h5 mb-0'>Ordered to " . $orders[0]['country'] . ", " . $orders[0]['city'] . ", reg: " . $orders[0]['region'] . "</p>
                    <p class='h5 mb-0'>Street: " . $orders[0]['street'] . ", postal: " . $orders[0]['postal'] . "</p>
                </div>
            ";


            // echo "
            // <div class='d-flex justify-content-between mb-3'>
            //     <p class='h5 mb-0'>Payment by " . $orders[0]['payment_type'] . "</p>
            //     <div class='dropdown'>
            //         <button class='btn btn-secondary btn-block dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' required>
            //         Order status
            //         </button>
            //         <div class='dropdown-menu btn btn-block text-center' aria-labelledby='dropdownMenuButton'>
            //             <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&state=placed' class='dropdown-item " . ($orders[0]['state'] == 'placed' ? 'active' : '') . "'>Placed</a>
            //             <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&state=in%20progress' class='dropdown-item " . ($orders[0]['state'] == 'in progress' ? 'active' : '') . "'>In progress</a>
            //             <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&state=delivered' class='dropdown-item " . ($orders[0]['state'] == 'delivered' ? 'active' : '') . "'>Delivered</a>
            //         </div>
            //     </div>
            // </div>
            // ";


            $sum = 0;
            foreach($orders as $order){
                $some_order = $db->getProductByID($order['product_id']);

                $picture = scandir("../uploaded_img/" . $order['product_id'], SCANDIR_SORT_DESCENDING)[0];

                echo "
                <div class='card shadow-0 border mb-4'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-2'>
                                <img src='../uploaded_img/" . $order['product_id'] . "/" . $picture . "'
                                class='img-fluid'>
                            </div>
                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                <p class='text-muted mb-0'>" . $some_order['title'] . "</p>
                            </div>
                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                <p class='text-muted mb-0 small'>" . $some_order['category'] . "</p>
                            </div>
                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                <p class='text-muted mb-0 small'>Qty: " . $order['quantity'] . "</p>
                            </div>
                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                <p class='text-muted mb-0 small'>$" . $some_order['price'] * $order['quantity'] . "</p>
                            </div>
                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                <p class='text-muted mb-0 small'>
                                    <div class='dropdown'>
                                        <button class='btn btn-secondary btn-block dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' required>
                                        Order status
                                        </button>
                                        <div class='dropdown-menu btn btn-block text-center' aria-labelledby='dropdownMenuButton'>
                                            <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&pr_id=" . encryptID($order['product_id'], "pr_id") . "&state=placed' class='dropdown-item " . ($orders[0]['state'] == 'placed' ? 'active' : '') . "'>Placed</a>
                                            <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&pr_id=" . encryptID($order['product_id'], "pr_id") . "&state=in%20progress' class='dropdown-item " . ($orders[0]['state'] == 'in progress' ? 'active' : '') . "'>In progress</a>
                                            <a href='read_order.php?id=" . $_GET['id'] . "&order_num=" . $_GET['order_num'] . "&pr_id=" . encryptID($order['product_id'], "pr_id") . "&state=delivered' class='dropdown-item " . ($orders[0]['state'] == 'delivered' ? 'active' : '') . "'>Delivered</a>
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                ";

                $sum += ($some_order['price'] * $order['quantity']);
            }
            ?>

            <div class="d-flex justify-content-between mb-3">
                <p class="text-muted mb-0">Total for products: <?php echo $sum; ?>$</p>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <p class="text-muted mb-0">Tax: <?php echo ($sum / 100); ?>$</p>
                <p class="text-muted mb-0"><span class="fw-bold me-4">Goverment taxes</span> needed</p>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <p class="text-muted mb-0">Shipping: <?php echo ($sum * 0.115); ?>$</p>
                <p class="text-muted mb-0"><span class="fw-bold me-4">Payment for</span> delivery man</p>
            </div>
            <div class="card-footer border-0 px-4 py-5" style="background-color: rgba(16, 46, 46, 1); border-bottom-left-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total paid: <span class="h2 mb-0 ms-2"><?php echo ($sum * 0.115) + $sum + ($sum / 100); ?>$</span></h5>
            </div>
        </div>
    </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<script src="../js/adm.js"></script>

</body>
</html>