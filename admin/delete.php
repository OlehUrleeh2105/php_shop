<?php
require '../db.php';
require '../enc.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$productID = $userID = decryptID($_GET['pr_id'], "pr_id");
$user = $db->getAdminByID($userID);

if (!$db->userExist($user['email']) && !$db->productExists($productID)) {
    header("location: ../index.php");
    exit();
}

$fileName = decryptID($_GET['f_name'], "name");

if(isset($_GET['f_name'])){
    if(unlink("../uploaded_img/" . $productID . "/" . $fileName)){
        header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
        exit();
    }
}

?>