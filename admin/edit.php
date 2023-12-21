<?php
require '../db.php';
require '../enc.php';
require 'functions.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$user = $db->getAdminByID($userID);

if (!$db->userExist($user['email']) && !$db->productExists(decryptID($_GET['pr_id'], "pr_id"))) {
    header("location: ../index.php");
    exit();
}

$res = decryptID($_GET['pr_id'], "pr_id");

$dir = "../uploaded_img/$res/";

if(isset($_FILES['files'])){
    if (uploadFiles($_FILES, $dir)){
        header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm_style.css">

    <title>Edit</title>
</head>
<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>

    <?php @include 'header.php'; ?>

    <main class="page-content">
        <div class="container">
            <div class="text-center mb-3">
                <h1>Edit</h1>
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                <?php 
                    $pr_id = decryptID($_GET['pr_id'], "pr_id");
                    $arr = scandir("../uploaded_img/" . $pr_id);
                    $count = count($arr) - 2;
                    if ($count > 1){
                        for($i = 0; $i < $count; $i++){
                            echo "
                            <div class='carousel-item " . ($i == 0 ? "active" : "") . "'>
                                <img class='d-block mx-auto' style='height: 450px;' src='../uploaded_img/" . $pr_id . "/" . $arr[$i + 2] . "'>
                                <div class='carousel-caption d-none d-md-block'>
                                    <h5 class='text-info'>". explode('.', $arr[$i+2])[0] . "</h5>
                                </div>
                            </div>
                            ";
                        }
                        echo "
                            </div>
                            <a class='carousel-control-prev bg-dark' href='#carouselExampleControls' role='button' data-slide='prev'>
                                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Previous</span>
                            </a>
                            <a class='carousel-control-next bg-dark' href='#carouselExampleControls' role='button' data-slide='next'>
                                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Next</span>
                            </a>
                        ";
                    } else {
                        echo "
                        <img class='d-block mx-auto' style='height: 450px;' src='../uploaded_img/" . $pr_id . "/" . $arr[2] . "'>
                        <div class='carousel-caption d-none d-md-block'>
                            <h5 class='text-info'>". explode('.', $arr[$i+2])[0] . "</h5>
                        </div>
                        ";
                    }
                ?>
            </div>
            <form action="edit.php?id=<?php echo $_GET['id']; ?>&pr_id=<?php echo $_GET['pr_id']; ?>" method="post" enctype="multipart/form-data" >
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                        <div class="custom-file">
                            <input type="file" name="files[]" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" multiple>
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary font-weight-bold mt-2">Upload New Photos</button>
            </form>
            <table class="table table-striped mt-3">
                <thead class="thead-light text-center">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                for($i = 0; $i < $count; $i++) {
                    echo "
                        <tr class='text-center'>
                            <th scope='row'>" . $arr[$i + 2] . "</th>
                            <td><button type='button' class='btn btn-outline-warning' data-toggle='modal' data-target='#exampleModal" . $i . "' data-whatever='@mdo'>Rename</button></td>
                            <td><a href='delete.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id'] . "&f_name=" . encryptID($arr[$i+2], "name") . "' class='btn btn-outline-danger'>Delete</a></td>
                        </tr>
                    ";

                    echo "                        
                    <div class='modal fade' id='exampleModal" . $i . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>New name</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form action='rename.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id'] . "&name=" . $arr[$i + 2] . "' method='post'>
                                        <div class='form-group'>
                                            <label for='recipient-name' class='col-form-label'>Rename to:</label>
                                            <input type='text' name='new_name' class='form-control' value='" .  explode('.', $arr[$i+2])[0] . "' id='recipient-name'>
                                        </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    <button type='submit' name='submit' class='btn btn-primary'>Change</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>
                </tbody>
            </table>
            <?php
                $product = $db->getProductByID(decryptID($_GET['pr_id'], "pr_id"));
            ?>
            <form action="update.php?id=<?php echo $_GET['id']; ?>&pr_id=<?php echo $_GET['pr_id']; ?>" method="post" class="border border-primary rounded mt-5" style="padding: 10px;">
                <div class="form-outline mb-4">
                    <label class="form-label font-weight-bold" for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo $product['title']; ?>" />
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label font-weight-bold" for="price">Price</label>
                    <input type="text" id="price" name="price" class="form-control" value="<?php echo $product['price']; ?>" />
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label font-weight-bold" for="category">Category</label>
                    <input type="text" id="category" name="category" class="form-control" value="<?php echo $product['category']; ?>" />
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label font-weight-bold" for="description">Description</label>
                    <textarea name="description" class="form-control" id="desc" rows="10"style="resize: none;"><?php echo $product['description']; ?></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block  font-weight-bold">UPDATE</button>
            </form>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="../js/adm.js"></script>

</body>
</html>