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

require 'functions.php';

if(isset($_POST['submit'])){
    $res = $db->insertProduct(decryptID($_GET['id'], "user_id"), $_POST['title'],  $_POST['price'], $_POST['category'], $_POST['description']);

    if(!$res) {
        header("location: adm_add.php?id=" . $_GET['id']);
        exit();
    }

    $dir = "../uploaded_img/$res";

    if(!is_dir($dir)){
        mkdir($dir, 0777, true);
    }

    $dir = "../uploaded_img/$res/";

    if(isset($_FILES['files'])){
        if (uploadFiles($_FILES, $dir)){
            header("location: products.php?id=" . $_GET['id'] . "&page=1");
            exit();
        }
    }
}
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm_style.css">
</head>

<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>

    <?php @include 'header.php'; ?>

    <main class="page-content">
        <div class="container">
            <form action="adm_add.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
                <div class="text-center">
                    <h1>Fill the fields</h1>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="title" class="font-weight-bold h5">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="price" class="font-weight-bold h5">Price</label>
                    <input type="number" name="price" class="form-control" id="price" step=0.5 placeholder="950.99" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="font-weight-bold h5">Category</label>
                    <input type="text" name="category" class="form-control" id="category" placeholder="Category">
                </div>
                <div class="form-group">
                    <label for="description" class="font-weight-bold h5">Description</label>
                    <textarea name="description" class="form-control" id="desc" rows="10" placeholder="Desctiption" style="resize: none;" required></textarea>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <h3>File to upload</h3>
                    </div>
                    <input type="file" name="files[]" multiple required>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary font-weight-bold btn-lg">Upload New Product</button>
                </div>
            </form>
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
