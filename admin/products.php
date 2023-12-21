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

if (isset($_GET['pr_id'])) {
    if ($db->deleteProduct(decryptID($_GET['pr_id'], "pr_id"))) {
        $folder = "../uploaded_img/" . decryptID($_GET['pr_id'], "pr_id");

        $files = glob($folder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folder);
        header("location: products.php?id=" . $_GET['id'] . "&page=1");
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
            <div class="text-center">
            <?php echo $_POST['sort_cat']; ?>
                <h1 class = "font-weight-bold mb-3 h1">Products</h1>
            </div>
            <div class="container">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">Img</th>
                        <th scope="col">Title</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $page = $_GET['page'];
                        if(!isset($_GET['page']) || $page == 1){
                            $page = 0;
                        } else {
                            $page = ($page * 8) - 8;
                        }

                        $base_arr = $db->getProducts($user['id'], $page);
                        foreach($base_arr as $rec){
                            $picture = scandir("../uploaded_img/" . $rec['id'], SCANDIR_SORT_DESCENDING)[0];
                            $msg = $rec['description'];
                            if (strlen($rec['description']) > 15) {
                                $msg = substr($rec['description'], 0, 15) . '...';
                            }
                            echo "
                            <tr>
                                <td><img src='../uploaded_img/" . $rec['id'] . "/" . $picture . "' style='width: 35px; height: 35px;'></td>
                                <td>" . $rec['title'] . "</td>
                                <td>" . $rec['price'] . "</td>
                                <td>" . $rec['category'] . "</td>
                                <td>" . $msg . "</td>
                                <td>" . DateTime::createFromFormat('Y-m-d H:i:s', $rec['created_at'])->format('d-m-Y') . "</td>
                                <td><div class='text-center'><a href='edit.php?id=" . $_GET['id'] . "&pr_id=" . encryptID($rec['id'], "pr_id") . "' class='btn'>✏️</a></div></td>
                                <td><div class='text-center'><a href='products.php?id=" . $_GET['id'] . "&pr_id=" . encryptID($rec['id'], "pr_id") . "' class='btn'>❌</a></div></td>
                            </tr>
                            ";
                        }
                        
                    ?>
                </tbody>
            </table>
            <?php
            $count = $db->getProductsCount($user['id']);
            $some = $count / 8;
            $some = ceil($some);

            echo "<div class='text-right'>";
                for($i = 1; $i <= $some; $i++){
                    if ($_GET['page'] == $i){
                        echo "
                            <a class='btn btn-outline-primary font-weight-bold mb-2 active' href='products.php?id=" . $_GET['id'] . "&page=" . $i . "#feedbacks'>$i</a>
                        ";
                    } else {
                        echo "
                            <a class='btn btn-outline-primary font-weight-bold mb-2' href='products.php?id=" . $_GET['id'] . "&page=" . $i . "#feedbacks'>$i</a>
                        ";
                    }
                }
            echo "</div>"
            ?>         
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