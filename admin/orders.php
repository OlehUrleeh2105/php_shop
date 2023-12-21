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
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Name</th>
                    <th class="text-center" scope="col">Surname</th>
                    <th class="text-center" scope="col">City</th>
                    <th class="text-center" scope="col">Region</th>
                    <th class="text-center" scope="col">Ordered</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($db->getAllOrderNumsByID($userID) as $num){
                    // $orders = $db->getOrderByNum($num['order_num'], $userID);
                    $order = $db->getOrderInfo($num['order_num'], $userID);
                    echo "
                        <tr class='text-center'>
                            <td>" . $order['name'] . "</td>
                            <td>" . $order['surname'] . "</td>
                            <td>" . $order['city'] . "</td>
                            <td>" . $order['region'] . "</td>
                            <td>" . DateTime::createFromFormat('Y-m-d H:i:s', $order['created_at'])->format('d-m-Y') . "</td>
                            <td><a class='btn btn-outline-light' href='read_order.php?id=" . $_GET['id'] . "&order_num=" . encryptID($num['order_num'], "order_num") . "'>Read All</a></td>
                        </tr>
                    ";
                    // foreach($orders as $order){
                    //     echo $order['product_id']; echo "</br>";
                    // }
                }
                ?>
            </tbody>
        </table>

            <!-- <div class="card shadow-0 border mb-4">
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
            </div> -->
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