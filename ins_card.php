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

    if($db->checkCardExist($userID, decryptID($_GET['pr_id'], "pr_id"))){
        $card = $db->getCardRecByID($userID, decryptID($_GET['pr_id'], "pr_id"));
        if(isset($_POST['submit'])){
            $card['quantity'] += $_POST['count'];
        } else {
            $card['quantity'] += 1;
        }
        if($db->updateCard($card)){
            header("Location: home.php");
            exit();         
        }
    }   
    
    $inserd_val = 1;
    if(isset($_POST['submit'])){
        $inserd_val = $_POST['count'];
    } 
    
    if($db->insertIntoCard($userID, decryptID($_GET['pr_id'], "pr_id"), $inserd_val)){
        header("location: home.php");
        exit();
    }
?>