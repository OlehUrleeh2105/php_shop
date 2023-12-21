<?php 
    require '../db.php';
    require '../enc.php';
    
    $db = new DB();
    
    if ((strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50)) {
        header("location: ../index.php");
        exit();
    }
    
    $userID = decryptID($_GET['id'], "user_id");
    $user = $db->getOwnerByID($userID);
    
    if (!$db->userExist($user['email'])) {
        header("location: ../index.php");
        exit();
    }

    if(isset($_GET['user_id']) && $_GET['action'] == "delete"){
        $products = $db->getAllProducts(decryptID($_GET['user_id'], "user_id"));

        if ($db->deleteUser(decryptID($_GET['user_id'], "user_id"))) {

            foreach($products as $product){
                if ($db->deleteProduct($product['id'])) {
                    $folder = "../uploaded_img/" . $product['id'];
                
                    $files = glob($folder . '/*');
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                    rmdir($folder);
                }
            }
            header("location: table_type.php?id=" . $_GET['id']);
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Table</title>
</head>
<body>

    <?php @include 'header.php'; ?>

    <div class="container">
        <p class="text-center display-4 mb-4 mt-4"><?php 
        if(!isset($_GET['type'])){
            echo 'All users';
        } elseif ($_GET['type'] == 'admin'){
            echo 'Admins';
        } else {
            echo 'Users';
        }
        ?> from database</p>
        <div class="row">
            <div class="col-sm-4 mb-2">
                <div class="text-left">
                    <a href="table_type.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-success <?php if(!isset($_GET['type'])) { echo 'active'; } ?>" style="border-radius: 20px; width: 90px;">All</a>
                    <a href="table_type.php?id=<?php echo $_GET['id']; ?>&type=user" class="btn btn-outline-primary <?php if($_GET['type'] == 'user') { echo 'active'; }?>" style="border-radius: 20px; width: 90px;">Users</a>
                    <a href="table_type.php?id=<?php echo $_GET['id']; ?>&type=admin" class="btn btn-outline-info <?php if($_GET['type'] == 'admin') { echo 'active'; }?>" style="border-radius: 20px; width: 90px;">Admins</a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Name</th>
                    <th class="text-center" scope="col">Surname</th>
                    <th class="text-center" scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_GET['type']) && $_GET['type'] == 'admin') {
                    $data = $db->getAdmins();
                } elseif (isset($_GET['type']) && $_GET['type'] == 'user') {
                    $data = $db->getUsers();
                } else {
                    $data = $db->getAllUsers();
                }
                foreach ($data as $row) {
                    echo "
                        <tr class='text-center'>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['surname'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td><a href='edit.php?id=" . $_GET['id'] . "&user_id=" . encryptID($row['id'], "user_id") . "' class='btn btn-outline-warning btn-block'>Edit</a></td>
                            <td><a href='table_type.php?id=" . $_GET['id'] . "&user_id=" . encryptID($row['id'], "user_id") . "&action=delete' class='btn btn-outline-danger btn-block'>Delete</a></td>
                        </tr>
                    ";
                }
            ?>
            </tbody>
        </table>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>