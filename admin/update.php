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

if (!$db->userExist($user['email']) && !$db->productExists(decryptID($_GET['pr_id'], "pr_id"))) {
    header("location: ../index.php");
    exit();
}

if (isset($_POST['submit'])) {
    if (empty($_POST['title']) || empty($_POST['price']) || empty($_POST['category']) || empty($_POST['description'])) {
        header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
        exit();
    }

    if ($db->updateProduct(decryptID($_GET['pr_id'], "pr_id"), $_POST['title'], $_POST['price'], $_POST['category'], $_POST['description'])) {
        header("location: edit.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
        exit();
    }
}
?>