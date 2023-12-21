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

if (!$db->userExist($user['email']) && !$db->productExists(decryptID($_GET['pr_id'], "pr_id"))) {
    header("location: index.php");
    exit();
}

if($db->isLiked($userID, decryptID($_GET['pr_id'], "pr_id"))){
    if ($db->setLike($userID, decryptID($_GET['pr_id'], "pr_id"))){
        header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
        exit();
    }
} else {
    if(!$db->isLikeExists($userID, decryptID($_GET['pr_id'], "pr_id"))){
        if($db->insertLike($userID, decryptID($_GET['pr_id'], "pr_id"))){
            header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
            exit();
        }
    } else {
        if ($db->setLike($userID, decryptID($_GET['pr_id'], "pr_id"))){
            header("location: view_more.php?id=" . $_GET['id'] . "&pr_id=" . $_GET['pr_id']);
            exit();
        }
    }
}
?>