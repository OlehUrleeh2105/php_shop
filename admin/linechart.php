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

$products = $db->getAllProducts($userID);
$dataRows = array();

if(!isset($_GET['pr_id'])){
    $res = $db->LineChart($products[0]['id']);
} else {
    $res = $db->LineChart(decryptID($_GET['pr_id'], "pr_id"));
}
$rows = array();

while ($data = mysqli_fetch_array($res)) {
    $date = $data['date'];
    $view_count = $data['view_count'];
    $p_id = $data['product_id'];
    $rows[] = "['$date', $view_count]";
}

$dataRows = $rows;
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
    <title>Admin panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm_style.css">


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'View Count'],
            <?php echo implode(',', $dataRows); ?>
        ]);

        var options = {
            title: 'Product Views',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>
</head>

<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>

    <?php @include 'header.php'; ?>

    <main class="page-content">
        <div class="text-center">
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Products
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php
                    foreach ($products as $index => $product) {
                        $pr_id = encryptID($product['id'], "pr_id");
                        $decrypted_pr_id = decryptID($_GET['pr_id'], "pr_id");
                        $activeClass = ($decrypted_pr_id === $product['id']) ? 'active' : '';
                        echo "<a class='dropdown-item $activeClass' href='linechart.php?id=" . $_GET['id'] . "&pr_id=$pr_id'>" . $product['title'] . "</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="text-left mb-5">
            <div id="curve_chart" style="width: 1300px; height: 700px"></div>
        </div>
    </main>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
        <script src="../js/adm.js"></script>
</body>

</html>
