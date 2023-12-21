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

//--------------------------------------
$encodedIds = $_GET['pr_ids'];
$pr_ids = explode(',', $encodedIds);

$decodedIds = array();
foreach ($pr_ids as $encodedId) {
    $decodedId = base64_decode($encodedId);
    $decodedIds[] = $decodedId;
}
//--------------------------------------

if(isset($_POST['submit'])){
    $payment_type = $_POST['payment_type'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $region = $_POST['region'];
    $postal = $_POST['postal'];
    $country = $_POST['country'];

    $success = true;

    $res_el = $db->getLastElementFromTable();
    $el = 0;
    if ($res_el === null) {
        $el = 1;
    } else {
        $el = $res_el + 1;
    }

    $adm = 0;
    foreach($decodedIds as $ids){
        $ssc = $db->getCardRecByID($userID, $ids);
        $adm = $db->getAdminByProduct($ids);
        if(!$db->insertOrder($userID, $ids, $user['name'], $user['surname'], $payment_type, $street, $city, $region, $postal, $country, $_POST['sum'], $el, $ssc['quantity'], $adm['user_id'])){
            $success = false;
            break;
        }
    }

    if($success){
        foreach($decodedIds as $ids){
            $some_card = $db->getCardRecByID($userID, $ids);
            $db->deleteFromCard($some_card['id']);
        }
        header("location: card.php?id=" . $_GET['id']);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Document</title>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">Your order, <span style="color: rgba(16, 46, 46, 1);"><?php echo "" . $user['surname'] . " " . $user['name'] . ""; ?></span></h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0" style="color: rgba(16, 46, 46, 1);">Receipt</p>
                        </div>

                        <?php
                            $sum = 0;
                            foreach ($decodedIds as $ids) {
                                $product = $db->getProductByID($ids);
                                $card = $db->getCardRecByID($userID, $ids);
                                $picture = scandir("uploaded_img/" . $product['id'], SCANDIR_SORT_DESCENDING)[0];
                                
                                $sum += ($product['price'] * $card['quantity']);
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
                                                <p class='text-muted mb-0 small'>Qty: " . $card['quantity'] . "</p>
                                            </div>
                                            <div class='col-md-2 text-center d-flex justify-content-center align-items-center'>
                                                <p class='text-muted mb-0 small'>$" . ($product['price'] * $card['quantity']) . "</p>
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

<section class="order-form m-4">
    <form action="order.php?id=<?php echo $_GET['id']; ?>&pr_ids=<?php echo $_GET['pr_ids'];?>" method="post">
    <div class="container pt-4">
        <div class="row">
            <div class="col-12 px-4">
                <h1>Order Form</h1>
            </div>

            <div class="col-12">
                
                <input type="hidden" name="payment_type" id="payment_type_input">

                <div class="row mt-3 mx-4">
                    <div class="col-12"> 
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                                Payment type
                            </button>
                            <div class="dropdown-menu btn btn-block text-center" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" onclick="setPaymentType('Card')">Card</a>
                                <a class="dropdown-item" onclick="setPaymentType('Cash')">Cash</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 mx-4">
                    <div class="col-12">
                        <label class="order-form-label">Adress</label>
                    </div>
                    <div class="col-12">
                        <div class="form-outline">
                            <input type="text" id="form5" maxlength="60" name="street" class="form-control order-form-input" placeholder="Street Address" required />
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 pe-sm-2">
                        <div class="form-outline">
                            <input type="text" id="form7" maxlength="40" name="city" class="form-control order-form-input" placeholder="City" required />
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 ps-sm-0">
                        <div class="form-outline">
                            <input type="text" id="form8" maxlength="40" name="region" class="form-control order-form-input" placeholder="Region" required />
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 pe-sm-2">
                        <div class="form-outline">
                            <input type="text" id="form9" maxlength="25" name="postal" class="form-control order-form-input" placeholder="Postal / Zip Code" required />
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 ps-sm-0">
                        <div class="form-outline">
                            <input type="text" id="form10" maxlength="35" name="country" class="form-control order-form-input" placeholder="Country" required />                       
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $sum * 0.115 + $sum + $sum / 100; ?>" name="sum" id="payment_type_input">
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary btn-block btn-lg font-weight-bold d-block mx-auto btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</section>

<?php @include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    function setPaymentType(paymentType) {
        document.getElementById('payment_type_input').value = paymentType;
    }
</script>


</body>
</html>
