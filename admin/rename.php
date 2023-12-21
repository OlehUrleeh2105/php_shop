<?php
require '../db.php';
require '../enc.php';

$db = new DB();

if (!isset($_GET['id']) || strlen($_GET['id']) < 4 || strlen($_GET['id']) > 50) {
    header("location: ../index.php");
    exit();
}

$userID = decryptID($_GET['id'], "user_id");
$productID = decryptID($_GET['pr_id'], "pr_id");
$user = $db->getAdminByID($userID);

if (!$db->userExist($user['email']) && !$db->productExists($productID)) {
    header("location: ../index.php");
    exit();
}

if($_POST['new_name'] == ""){
    header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
    exit();
}

if (isset($_POST['submit'])) {
    $productID = decryptID($_GET['pr_id'], "pr_id");
    $oldName = $_GET['name'];
    $newName = $_POST['new_name'];

    $extension = pathinfo($oldName, PATHINFO_EXTENSION);

    $oldPath = "../uploaded_img/" . $productID . "/" . $oldName;
    $newPath = "../uploaded_img/" . $productID . "/" . $newName . "." . $extension;

    if (file_exists($oldPath)) {
        if (rename($oldPath, $newPath)) {
            header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
            exit();
        }
    } else {
        header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
        exit();
    }
}


?>